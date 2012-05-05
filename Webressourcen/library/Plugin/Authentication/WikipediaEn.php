<?php
    /** This plugin is used to get get the content of a page while logged in
      * You need to pass your login-data in wpName and wpPassword
      * @author Christoph Beger
      */
    class Plugin_Authentication_WikipediaEn
    {
        /* Login-Data for english wikipedia */ 
        private $wpName = 'Swp6 12';       //username
        private $wpPassword = 'invitator'; //password
        
        /** This function creates a Zend_Http_Client to login at the english wikipedia-page.
          * @url URL to the content you need
          * @return content of the specified page
          */
        public function getResponse( $url)
        {
            $client = new Zend_Http_Client( 'http://en.wikipedia.org/w/index.php?title=Special:UserLogin&returnto=Main+Page');
            
            $client->setCookieJar();
            
            $firstResponse = $client->request( 'GET');
            
            /* get the value of wpLoginToken in the response */
            list( $firstPart, $rest) = explode( '<input type="hidden" name="wpLoginToken" value="', $firstResponse->getBody());
            $wpLoginToken = substr( $rest, 0, 32);
            
            /* login with userName and password */
            $client->setUri('http://en.wikipedia.org//w/index.php?title=Special:UserLogin&action=submitlogin&type=login&returnto=Main+Page');
            $client->setParameterPost( 'wpName', $this->wpName);
            $client->setParameterPost( 'wpPassword', $this->wpPassword);
            $client->setParameterPost( 'wpLoginAttempt', 'Log in');
            $client->setParameterPost( 'wpLoginToken', $wpLoginToken);
            $client->request( 'POST');
            
            /* get the topicContent */
            $client->setUri( $url);
            return $client->request();
        }
    }
?>