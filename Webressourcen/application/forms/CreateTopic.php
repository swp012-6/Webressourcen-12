<?php
/** This class is a formular to create a new topic
* @author Christoph Beger
*/
class Application_Form_CreateTopic extends Zend_Form
{

    public function init()
    {
        $this->setMethod( 'post');
$this->setAttrib( 'action', 'validate');
$this->addElement( 'radio', 'topicType', array( 'label' => $this->getView()->translate( 'Typ:'),
                                                        'multioptions' => array( 0 => $this->getView()->translate( 'Text'),
                                                                                    1 => $this->getView()->translate( 'Link')),
'separator' => ' ',
                                                        'value' => 0));
$this->addElement( 'text', 'topicName', array( 'label' => $this->getView()->translate( 'Topic-Name:')));
$this->addElement( 'textarea', 'topicContent', array( 'label' => $this->getView()->translate( 'Inhalt:'), 'rows' =>20, 'cols' => 90));
        $this->getElement( 'topicContent')->addValidator( new BV_Validate_Uri());
$this->addElement( 'text', 'topicSource', array( 'label' => $this->getView()->translate( 'Quelle:')));
$this->addElement( 'submit', $this->getView()->translate( 'erstellen'));
    }


}

