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
   
    /** 
     * adds a submitbutton to the form
     */
    public function addSendButton()
    {
        $this->addElement( 'submit', 'neuen_Freund_einladen');
    }
   
    /** 
     * adds a submitbutton to the form
     */
    public function addButton()
    {
        $this->addElement( 'submit', 'erstellen');
    }
   
    /** 
     * adds a submitbutton to the form
     */
    public function editButton($edit)
    {
        $this->addElement( 'hidden', 'edit', array('value' => $edit));
        $this->addElement( 'submit', 'ändern');
    }

}
?>
