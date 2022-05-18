<?php 
class Hj_Vendor_Model_Resource_Setup extends Mage_Eav_Model_Entity_Setup
{
    public function getDefaultEntities()
    {
        $entities = array(
            'vendor' => array(
                'entity_model' => 'vendor/vendor',
                'attribute_model' => '',
                'table' => 'vendor/vendor_entity',
                'attributes' => array(
                    'first_name' => array(
                        'type' => 'varchar',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'First Name',
                        'input' => 'text',
                        'class' => '',
                        'source' => '',
                        'global' => 0,
                        'sort_order' => 1,
                        'visible' => true,
                        'required' => true,
                        'user_defined' => true,
                        'default' => '',
                        'searchable' => false,
                        'filterable' => false,
                        'comparable' => false,
                        'visible_on_front' => true,
                        'unique' => false,
                    ),
                    'last_name' => array(
                        'type' => 'varchar',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'Last Name',
                        'input' => 'text',
                        'class' => '',
                        'source' => '',
                        'global' => 0,
                        'sort_order' => 2,
                        'visible' => true,
                        'required' => false,
                        'user_defined' => true,
                        'default' => '',
                        'searchable' => false,
                        'filterable' => false,
                        'comparable' => false,
                        'visible_on_front' => true,
                        'unique' => false,
                    ),
                    'email' => array(
                        'type' => 'varchar',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'Email',
                        'input' => 'text',
                        'class' => '',
                        'source' => '',
                        'global' => 0,
                        'sort_order' => 3,
                        'visible' => true,
                        'required' => true,
                        'user_defined' => true,
                        'default' => '',
                        'searchable' => false,
                        'filterable' => false,
                        'comparable' => false,
                        'visible_on_front' => true,
                        'unique' => true,
                    ),
                    'mobile' => array(
                        'type' => 'varchar',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'Mobile',
                        'input' => 'text',
                        'class' => '',
                        'source' => '',
                        'global' => 0,
                        'sort_order' => 4,
                        'visible' => true,
                        'required' => false,
                        'user_defined' => true,
                        'default' => '',
                        'searchable' => false,
                        'filterable' => false,
                        'comparable' => false,
                        'visible_on_front' => true,
                        'unique' => true,
                    ),
                    'status' => array(
                        'type' => 'int',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'Status',
                        'input' => 'select',
                        'class' => '',
                        'source' => '',
                        'global' => 0,
                        'sort_order' => 5,
                        'visible' => true,
                        'required' => true,
                        'user_defined' => true,
                        'default' => '',
                        'searchable' => false,
                        'filterable' => false,
                        'comparable' => false,
                        'visible_on_front' => true,
                        'unique' => true,
                    ),
                    'created_date' => array(
                        'type' => 'datetime',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'Created Date',
                        'input' => 'text',
                        'class' => '',
                        'source' => '',
                        'global' => 0,
                        'sort_order' => 6,
                        'visible' => true,
                        'required' => true,
                        'user_defined' => true,
                        'default' => '',
                        'searchable' => false,
                        'filterable' => false,
                        'comparable' => false,
                        'visible_on_front' => true,
                        'unique' => true,
                    ),
                    'updated_date' => array(
                        'type' => 'datetime',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'Updated Date',
                        'input' => 'text',
                        'class' => '',
                        'source' => '',
                        'global' => 0,
                        'sort_order' => 7,
                        'visible' => true,
                        'required' => true,
                        'user_defined' => true,
                        'default' => '',
                        'searchable' => false,
                        'filterable' => false,
                        'comparable' => false,
                        'visible_on_front' => true,
                        'unique' => true,
                    )
                ),
            )
        );
        return $entities;
    }
}