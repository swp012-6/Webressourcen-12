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
        $this->addElement( 'text', 'firstName', array( 'label' => $this->getView()->translate( 'Vorname:')));
        $this->addElement( 'text', 'lastName', array( 'label' => $this->getView()->translate( 'Nachname:')));
        $this->addElement( 'text', 'email', array( 'label' => $this->getView()->translate( 'Email-Adresse:')));
        $this->addElement( 'text', 'job', array( 'label' => $this->getView()->translate( 'Beruf:')));
        $this->addElement( 'text', 'adresse', array( 'label' => $this->getView()->translate( 'Adresse:')));
    }
   
    /** 
     * adds a submitbutton to the form
     * @param $topicID ID of the topic
     */
    public function addSendButton($topicID)
    {
        $this->addElement( 'hidden', 'topicID', array('value' => $topicID));
        $this->addElement( 'submit', $this->getView()->translate( 'neuen_Freund_einladen'));
    }
   
    /** 
     * adds a submitbutton to the form
     */
    public function addButton()
    {
        $this->addElement( 'submit', $this->getView()->translate( 'erstellen'));
    }
   
    /** 
     * adds a submitbutton to the form
     * @param $edig ID of the user
     */
    public function editButton($edit)
    {
        $this->addElement( 'hidden', 'edit', array('value' => $edit));
        $this->addElement( 'submit', $this->getView()->translate( 'ändern'));
    }

}
?>
