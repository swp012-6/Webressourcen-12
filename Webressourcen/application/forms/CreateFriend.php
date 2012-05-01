<?php
/** This form is used to get data for creating a new friend.
  * First you have to create an instance of this class.
  * After this, use the function setTopicID() to add the topicID and the submitbutton
  *
  * @author Christoph Beger
  */
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
    }
   
    /** adds the topicID and a submitbutton to the form
      * @param $topicID ID of the topic which will be accessible by the created user
      */
    public function setTopicID( $topicID)
    {
        $this->addElement( 'hidden', 'topicID', array( 'value' => $topicID));
        $this->addElement( 'submit', 'neuen Freund einladen');
    }


}

