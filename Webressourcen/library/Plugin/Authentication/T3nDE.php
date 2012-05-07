<?php
    /** This plugin is used to get the content of a t3n.de page while logged in
      * You need to pass your login-data in user and pass
      * @author Christoph Beger
      */
    class Plugin_Authentication_T3nDE
    {
        /* Login-Data for t3n.de */ 
        private $user = 'Swp612@mailcatch.com';       //emailadresse
        private $pass = 'invitator';                  //password
        
        /** This function creates a Zend_Http_Client to login on t3n.de.
          * @url URL to the content you need
          * @return content of the specified page
          */
        public function getResponse( $url)
        {
            $client = new Zend_Http_Client( 'https://t3n.de/app/');
            
            $client->setCookieJar();
            
            $client->setParameterPost( 'redirect_url', '/');
            $client->setParameterPost( 'pid', '214');
            $client->setParameterPost( 'id', '231');
            $client->setParameterPost( 'logintype', 'login');
            $client->setParameterPost( 'user', $this->user);
            $client->setParameterPost( 'pass', $this->pass);
            $client->request( 'POST');
            
            /* get the topicContent */
            $client->setUri( $url);
            return $client->request();
        }
    }
?>