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
		$this->addElement( 'radio', 'topicType', array(	'label' => 'Typ:',
                                                        'multioptions' => array(	0 => 'Text',
                                                                                    1 => 'Link'),
							'separator' => '  ',
                                                        'value' => 0));
		$this->addElement( 'text', 'topicName', array( 'label' => 'Topic-Name:'));
		$this->addElement( 'textarea', 'topicContent', array( 'label' => 'Inhalt:', 'rows' =>20, 'cols' => 90));
        $this->getElement( 'topicContent')->addValidator( new BV_Validate_Uri());
		$this->addElement( 'text', 'topicSource', array( 'label' => 'Quelle:'));
		$this->addElement( 'submit', 'erstellen');
    }


}

