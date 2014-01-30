<?php

namespace Pipeline\APIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Pipeline\APIBundle\Constants;

class TaskType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('error_bubbling' => true))
            ->add('status', 'choice', array('choices' => array(Constants::STATUS_ACTIVE, 
                                                               Constants::STATUS_COMPLETE, 
                                                               Constants::STATUS_PENDING, 
                                                               Constants::STATUS_REJECTED, 
                                                               Constants::STATUS_REQUEST
                                                               ),
                                            'error_bubbling' => true))
            ->add('description', 'textarea', array('error_bubbling' => true))
            ->add('createdAt', 'datetime', array('error_bubbling' => true))
            ->add('updatedAt', 'datetime', array('error_bubbling' => true))
            ->add('scheduledAt', 'datetime', array('error_bubbling' => true))
            ->add('dueAt', 'datetime', array('error_bubbling' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pipeline\APIBundle\Entity\Task',
            'csrf_protection' =>  false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'task';
    }
}
