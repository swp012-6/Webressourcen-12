<?php

class Application_Form_CreateFriend extends Zend_Form
{

    public function init()
    {
        $this->setMethod( 'post');
        $this->setAttrib( 'action', 'createfriend');
        $this->addElement( 'text', 'firstName', array( 'label' => 'Vorname:'));
        $this->addElement( 'text', 'lastName', array( 'label' => 'Nachname:'));
        $this->addElement( 'text', 'email', array( 'label' => 'Email-Adresse:'));
        $this->addElement( 'text', 'job', array( 'label' => 'Beruf:'));
        $this->addElement( 'text', 'adresse', array( 'label' => 'Adresse:'));
        $this->addElement( 'submit', 'neuen Freund einladen');
    }
    
    public function setTopicID( $topicID)
    {
        $this->addElement( 'hidden', 'topicID', array( 'value' => $topicID));
    }


}

