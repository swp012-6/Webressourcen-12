<?php
    /** This plugin is used to get get the content of a page while loged in
      * You need to pass your login-data in wpName and wpPassword
      * @author Christoph Beger
      */
    class Plugin_Authentication_WikipediaDe
    {
        /* Login-Data for german wikipedia */ 
        private $wpName = 'Swp6 12';       //username
        private $wpPassword = 'invitator'; //password
        
        /** This function creates a Zend_Http_Client to login at the german wikipedia-page.
          * @url URL to the content you need
          * @return content of the specified page
          */
        public function getResponse( $url)
        {
            $client = new Zend_Http_Client( 'http://de.wikipedia.org/w/index.php?title=Spezial:Anmelden&returnto=Wikipedia%3AHauptseite');
            
            $client->setCookieJar();
            
            $firstResponse = $client->request( 'GET');
            
            /* get the value of wpLoginToken in the response */
            list( $firstPart, $rest) = explode( '<input type="hidden" name="wpLoginToken" value="', $firstResponse->getBody());
            $wpLoginToken = substr( $rest, 0, 32);
            
            /* login with userName and password */
            $client->setUri('http://de.wikipedia.org/w/index.php?title=Spezial:Anmelden&action=submitlogin&type=login&returnto=Wikipedia:Hauptseite');
            $client->setParameterPost( 'wpName', $this->wpName);
            $client->setParameterPost( 'wpPassword', $this->wpPassword);
            $client->setParameterPost( 'wpLoginAttempt', 'Anmelden');
            $client->setParameterPost( 'wpLoginToken', $wpLoginToken);
            $client->request( 'POST');
            
            /* get the topicContent */
            $client->setUri( $url);
            return $client->request();
        }
    }
?>