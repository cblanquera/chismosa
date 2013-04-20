<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * General available methods for common POP3 functionality
 *
 * @package    Eden
 * @category   mail
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Mail_Pop3 extends Eden_Class {
	/* Constants
	-------------------------------*/
	const TIMEOUT			= 30;
	const NO_SUBJECT		= '(no subject)';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_host		= NULL;
	protected $_port		= NULL;
	protected $_ssl		 	= false;
	protected $_tls		 	= false;
	
	protected $_username	= NULL;
	protected $_password	= NULL;
	protected $_timestamp	= NULL;
	
	protected $_socket 		= NULL;
	
	protected $_loggedin	= false;
	
	/* Private Properties
	-------------------------------*/
	private $_debugging		= false;
	
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($host, $user, $pass, $port = NULL, $ssl = false, $tls = false) {
		Eden_Mail_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'int', 'null')
			->argument(5, 'bool')
			->argument(6, 'bool');
			
		if (is_null($port)) {
            $port = $ssl ? 995 : 110;
        }

		$this->_host 		= $host;
		$this->_username 	= $user;
		$this->_password 	= $pass;
		$this->_port 		= $port;
		$this->_ssl 		= $ssl;
		$this->_tls 		= $tls;
		
		$this->connect();
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Connects to the server
	 *
	 * @return this
	 */
	public function connect($test = false) {
		Eden_Mail_Error::i()->argument(1, 'bool');
		
		if($this->_loggedin) {
			return $this;
		}
		
		$host = $this->_host;
		
		if ($this->_ssl) {
            $host = 'ssl://' . $host;
        }
		
		$errno  =  0;
        $errstr = '';
        
		$this->_socket = fsockopen($host, $this->_port, $errno, $errstr, self::TIMEOUT);
        
		if (!$this->_socket) {
			//throw exception
			Eden_Mail_Error::i()->setMessage(Eden_Mail_Error::SERVER_ERROR)
				->addVariable($host.':'.$this->_port)
				->trigger();
        }
		
		$welcome = $this->_receive();

        strtok($welcome, '<');
        $this->_timestamp = strtok('>');
        if (!strpos($this->_timestamp, '@')) {
            $this->_timestamp = null;
        } else {
            $this->_timestamp = '<' . $this->_timestamp . '>';
        }

        if ($this->_tls) {
            $this->_call('STLS');
            if (!stream_socket_enable_crypto($this->_socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
				$this->disconnect();
            	//throw exception
				Eden_Mail_Error::i()->setMessage(Eden_Mail_Exception::TLS_ERROR)
					->addVariable($host.':'.$this->_port)
					->trigger();
            }
        }
		
		if($test) {
			$this->disconnect();
			return $this;
		}
		
		//login
		if ($this->_timestamp) {
            try {
                $this->_call('APOP '.$this->_username .' ' . md5($this->_timestamp . $this->_password));
                return;
            } catch (Exception $e) {
                // ignore
            }
        }

        $this->_call('USER '.$this->_username);
        $this->_call('PASS '.$this->_password);
		
		$this->_loggedin = true;
		
		return $this;
	}
	
	/**
	 * Disconnects from the server
	 *
	 * @return this
	 */
	public function disconnect() {
		if (!$this->_socket) {
            return;
        }

        try {
            $this->request('QUIT');
        } catch (Exception $e) {
            // ignore error - we're closing the socket anyway
        }

        fclose($this->_socket);
        $this->_socket = NULL;
	}
	
	/**
	 * Returns a list of emails given the range
	 *
	 * @param number start
	 * @param number range
	 * @return array
	 */
	public function getEmails($start = 0, $range = 10) {
		Eden_Mail_Error::i()
			->argument(1, 'int')
			->argument(2, 'int');
		
		$total = $this->getEmailTotal();
		$total = $total['messages'];
		
		if($total == 0) {
			return array();
		}
		
        if (!is_array($start)) {
			$range = $range > 0 ? $range : 1;
			$start = $start >= 0 ? $start : 0;
			$max = $total - $start;

			if($max < 1) {
				$max = $total;
			}
			
			$min = $max - $range + 1;
			
			if($min < 1) {
				$min = 1;
			}
			
			$set = $min . ':' . $max; 
			
			if($min == $max) {
				$set = $min; 
			}
        }
		
		
		$emails = array();
		for($i = $min; $i <= $max; $i++) {
			$emails[] = $this->_getEmailFormat($this->_call('RETR '.$i, true));
		}
		
		return $emails;
    }
	
	/**
	 * Returns the total number of emails in a mailbox
	 *
	 * @return number
	 */
	public function getEmailTotal() {
		list($messages, $octets) = explode(' ', $this->_call('STAT'));

		return $messages;	
	}
	
	/**
	 * Remove an email from a mailbox
	 *
	 * @param number uid
	 * @param string mailbox
	 * @return this
	 */
	public function remove($msgno) {
		Eden_Mail_Error::i()->argument(1, 'int', 'string');
		
		$this->_call("DELE $msgno");
		
		if(!$this->_loggedin || !$this->_socket) {
			return false;
		}
		
		if(!is_array($msgno)) {
			$msgno = array($msgno);
		}
		
		foreach($msgno as $number) {
			$this->_call('DELE '.$number);
		
		}
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _call($command, $multiline = false) {
		if(!$this->_send($command)) {
			return false;
		}
		
		return $this->_receive($multiline);
	}
	
	protected function _receive($multiline = false) {
		$result = @fgets($this->_socket);
        $status = $result = trim($result);
        $message = '';
		
		if (strpos($result, ' ')) {
            list($status, $message) = explode(' ', $result, 2);
        }

        if ($status != '+OK') {
            return false;
        }

        if ($multiline) {
            $message = '';
            $line = fgets($this->_socket);
            while ($line && rtrim($line, "\r\n") != '.') {
                if ($line[0] == '.') {
                    $line = substr($line, 1);
                }
				$this->_debug('Receiving: '.$line);
                $message .= $line;
                $line = fgets($this->_socket);
            };
        }

        return $message;
    }

	protected function _send($command) {
		
		$this->_debug('Sending: '.$command);
		
        return fputs($this->_socket, $command . "\r\n");
   }
	/* Private Methods
	-------------------------------*/
	private function _debug($string) {
		if($this->_debugging) {
			$string = htmlspecialchars($string);
			
			
			echo '<pre>'.$string.'</pre>'."\n";
		}
		return $this;
	}
	
	private function _getEmailFormat($email, array $flags = array()) {
		//if email is an array
		if(is_array($email)) {
			//make it into a string
			$email = implode("\n", $email);
		}
		
		//split the head and the body
		$parts = preg_split("/\n\s*\n/", $email, 2);
		
		$head = $parts[0]; 
		$body = NULL;
		if(isset($parts[1]) && trim($parts[1]) != ')') {
			$body = $parts[1];
		}
		
		$lines = explode("\n", $head);
		$head = array();
		foreach($lines as $line) {
			if(trim($line) && preg_match("/^\s+/", $line)) {
				$head[count($head)-1] .= ' '.trim($line);
				continue;
			}
			
			$head[] = trim($line);
		}
		
		$head = implode("\n", $head);
		
		$recipientsTo = $recipientsCc = $recipientsBcc = $sender = array();
		
		//get the headers
		$headers1 	= imap_rfc822_parse_headers($head);
		$headers2 	= $this->_getHeaders($head);
		
		//set the from
		$sender['name'] = NULL;
		if(isset($headers1->from[0]->personal)) {
			$sender['name'] = $headers1->from[0]->personal;
			//if the name is iso or utf encoded
			if(preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($sender['name']))) {
				//decode the subject
				$sender['name'] = str_replace('_', ' ', mb_decode_mimeheader($sender['name']));
			}
		}
		
		$sender['email'] = $headers1->from[0]->mailbox . '@' . $headers1->from[0]->host;
		
		//set the to
		if(isset($headers1->to)) {
			foreach($headers1->to as $to) {
				if(!isset($to->mailbox, $to->host)) {
					continue;
				}
				
				$recipient = array('name'=>NULL);
				if(isset($to->personal)) {
					$recipient['name'] = $to->personal;
					//if the name is iso or utf encoded
					if(preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($recipient['name']))) {
						//decode the subject
						$recipient['name'] = str_replace('_', ' ', mb_decode_mimeheader($recipient['name']));
					}
				}
				
				$recipient['email'] = $to->mailbox . '@' . $to->host;
				
				$recipientsTo[] = $recipient;
			}
		}
		
		//set the cc
		if(isset($headers1->cc)) {
			foreach($headers1->cc as $cc) {
				$recipient = array('name'=>NULL);
				if(isset($cc->personal)) {
					$recipient['name'] = $cc->personal;
					
					//if the name is iso or utf encoded
					if(preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($recipient['name']))) {
						//decode the subject
						$recipient['name'] = str_replace('_', ' ', mb_decode_mimeheader($recipient['name']));
					}
				}
				
				$recipient['email'] = $cc->mailbox . '@' . $cc->host;
				
				$recipientsCc[] = $recipient;
			}
		}
		
		//set the bcc
		if(isset($headers1->bcc)) {
			foreach($headers1->bcc as $bcc) {
				$recipient = array('name'=>NULL);
				if(isset($bcc->personal)) {
					$recipient['name'] = $bcc->personal;				
					//if the name is iso or utf encoded
					if(preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($recipient['name']))) {
						//decode the subject
						$recipient['name'] = str_replace('_', ' ', mb_decode_mimeheader($recipient['name']));
					}
				}
				
				$recipient['email'] = $bcc->mailbox . '@' . $bcc->host;
				
				$recipientsBcc[] = $recipient;
			}
		}
		
		//if subject is not set
		if(!isset( $headers1->subject ) || strlen(trim($headers1->subject)) === 0) {
			//set subject
			$headers1->subject = self::NO_SUBJECT;
		}
		
		//trim the subject
		$headers1->subject = str_replace(array('<', '>'), '', trim($headers1->subject));
		
		//if the subject is iso or utf encoded
		if(preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($headers1->subject))) {
			//decode the subject
			$headers1->subject = str_replace('_', ' ', mb_decode_mimeheader($headers1->subject));
		}
		
		//set thread details
		$topic 	= isset($headers2['thread-topic']) ? $headers2['thread-topic'] : $headers1->subject;
		$parent = isset($headers2['in-reply-to']) ? str_replace('"', '', $headers2['in-reply-to']) : NULL;
		
		//set date
		$date = isset($headers1->date) ? strtotime($headers1->date) : NULL;
		
		//set message id
		if(isset($headers2['message-id'])) {
			$messageId = str_replace('"', '', $headers2['message-id']);
		} else {
			$messageId = '<eden-no-id-'.md5(uniqid()).'>';
		}
		
		$attachment = isset($headers2['content-type']) && strpos($headers2['content-type'], 'multipart/mixed') === 0;
		
		$format = array(
			'id'			=> $messageId,
			'parent'		=> $parent,
			'topic'			=> $topic,
			'mailbox'		=> 'INBOX',
			'date'			=> $date,
			'subject'		=> str_replace('’', '\'', $headers1->subject),
			'from'			=> $sender,
			'flags'			=> $flags,
			'to'			=> $recipientsTo,
			'cc'			=> $recipientsCc,
			'bcc'			=> $recipientsBcc,
			'attachment'	=> $attachment);
		
		if(trim($body) && $body != ')') {
			//get the body parts
			$parts = $this->_getParts($email);
			
			//if there are no parts
			if(empty($parts)) {
				//just make the body as a single part
				$parts = array('text/plain' => $body);
			} 
			
			//set body to the body parts
			$body = $parts;
			
			//look for attachments
			$attachment = array();
			//if there is an attachment in the body
			if(isset($body['attachment'])) {
				//take it out
				$attachment = $body['attachment'];
				unset($body['attachment']);
			}
			
			$format['body']			= $body;
			$format['attachment']	= $attachment;
		}
		
		return $format;
	} 
	
	
	private function _getHeaders($rawData) {
		if(is_string($rawData)) {
			$rawData = explode("\n", $rawData);
		}
		
		$key = NULL;
		$headers = array();
		foreach($rawData as $line) {
			$line = trim($line);
			if(preg_match("/^([a-zA-Z0-9-]+):/i", $line, $matches)) {
				$key = strtolower($matches[1]);
				if(isset($headers[$key])) {
					if(!is_array($headers[$key])) {
						$headers[$key] = array($headers[$key]);
					}
					
					$headers[$key][] = trim(str_replace($matches[0], '', $line));
					continue;
				} 
				
				$headers[$key] = trim(str_replace($matches[0], '', $line));
				continue;
			} 
			
			if(!is_null($key) && isset($headers[$key])) {
				if(is_array($headers[$key])) {
					$headers[$key][count($headers[$key])-1] .= ' '.$line;	
					continue;
				}
				
				$headers[$key] .= ' '.$line; 
			}
		}
		
		return $headers;
	}
	
	private function _getParts($content, array $parts = array()) {
		//separate the head and the body
		list($head, $body) = preg_split("/\n\s*\n/", $content, 2);
		//front()->output($head);
		//get the headers
		$head = $this->_getHeaders($head);
		//if content type is not set
		if(!isset($head['content-type'])) {
			return $parts;
		}
		
		//split the content type
		if(is_array($head['content-type'])) {
			$type = array($head['content-type'][1]);
			if(strpos($type[0], ';') !== false) {
				$type = explode(';', $type[0], 2);
			}
		} else {
			$type = explode(';', $head['content-type'], 2);
		}
		
		//see if there are any extra stuff
		$extra = array();
		if(count($type) == 2) {
			$extra = explode('; ', str_replace(array('"', "'"), '', trim($type[1])));
		}
		
		//the content type is the first part of this
		$type = trim($type[0]);
		
		
		//foreach extra
		foreach($extra as $i => $attr) {
			//transform the extra array to a key value pair
			$attr = explode('=', $attr, 2);
			if(count($attr) > 1) {
				list($key, $value) = $attr;
				$extra[$key] = $value;
			}
			unset($extra[$i]);
		}
		
		//if a boundary is set
		if(isset($extra['boundary'])) {
			//split the body into sections
			$sections = explode('--'.str_replace(array('"', "'"), '', $extra['boundary']), $body);
			//we only want what's in the middle of these sections
			array_pop($sections);
			array_shift($sections);
			
			//foreach section
			foreach($sections as $section) {
				//get the parts of that
				$parts = $this->_getParts($section, $parts);	
			}
		//if name is set, it's an attachment
		} else {
			
			//if encoding is set
			if(isset($head['content-transfer-encoding'])) {
				//the goal here is to make everytihg utf-8 standard
				switch(strtolower($head['content-transfer-encoding'])) {
					case 'binary':
						$body = imap_binary($body);
					case 'base64':
						$body = base64_decode($body);
						break;
					case 'quoted-printable':
						$body = quoted_printable_decode($body);
						break;
					case '7bit':
						$body = mb_convert_encoding ($body, 'UTF-8', 'ISO-2022-JP');
						break;
					default:
						$body = str_replace(array("\n", ' '), '', $body);
						break;
				}
			}
			
			if(isset($extra['name'])) {
				//add to parts
				$parts['attachment'][$extra['name']][$type] = $body;
			//it's just a regular body
			} else {
				//add to parts
				$parts[$type] = $body;
			}
		}
		return $parts;
	}
}