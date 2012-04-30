<?php

class Application_Form_CreateComment extends Zend_Form
{

    public function init()
    {
        $this->setMethod( 'post');
        $this->setAttrib( 'action', 'validatecomment');
        $this->addElement( 'checkbox', 'anonymous', array( 'label' => 'Anonymous:' ));
        $this->addElement( 'textarea', 'commentText', array( 'label' => 'Kommentar', 'rows' => '10', 'cols' => '50'));
        $this->addElement( 'submit', 'senden');
    }
    
    public function setIDs( $topicID, $userID, $topicVersion)
    {
        $this->addElement( 'hidden', 'topicID', array( 'value' => $topicID));
        $this->addElement( 'hidden', 'userID', array( 'value' => $userID));
        $this->addElement( 'hidden', 'topicVersion', array( 'value' => $topicVersion));
    }
}

