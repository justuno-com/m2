<?php

namespace Justuno\Jumagext\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Authorization\Model\Role;
use Magento\User\Model\User;
use Magento\Authorization\Model\ResourceModel\Role\Collection

/* For get RoleType and UserType for create Role   */;
use Magento\Authorization\Model\Acl\Role\Group as RoleGroup;
use Magento\Authorization\Model\UserContextInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    protected $_userFactory;
    protected $justunorole;
    protected $userModel;
    protected $roleAuthModel;

    /**
     * RoleFactory
     *
     * @var roleFactory
     */
    private $roleFactory;

     /**
     * RulesFactory
     *
     * @var rulesFactory
     */
    private $rulesFactory;
    /**
     * Init
     *
     * @param \Magento\Authorization\Model\RoleFactory $roleFactory
     * @param \Magento\Authorization\Model\RulesFactory $rulesFactory
     */
    function __construct(
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\Authorization\Model\RoleFactory $roleFactory, /* Instance of Role*/
        \Magento\Authorization\Model\RulesFactory $rulesFactory, /* Instance of Rule */
        \Magento\Authorization\Model\Role $roleAuthModel ,
        \Magento\User\Model\User $userModel ,
        \Magento\Authorization\Model\ResourceModel\Role\Collection $justunorole
        /*this define that which resource permitted to wich role */
        )
    {
        $this->_userFactory     = $userFactory;
        $this->roleFactory      = $roleFactory;
        $this->rulesFactory     = $rulesFactory;
        $this->roleAuthModel    = $roleAuthModel;
        $this->userModel        = $userModel;
        $this->justunorole      = $justunorole;
    }



    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
        * Create Justuno role
        */
        $role = $this->roleFactory->create();
        $role->setName('justunoUser')
                ->setPid(0)
                ->setRoleType(RoleGroup::ROLE_TYPE)
                ->setUserType(UserContextInterface::USER_TYPE_ADMIN);
        $role->save();

        $resource=['Magento_Backend::admin',
                    'Magento_Catalog::catalog',
                    'Magento_Catalog::products',
                    'Magento_Catalog::categories',
                    'Magento_Customer::customer',
                    'Magento_Customer::manage',
                    'Magento_Sales::sales',
                    'Magento_Sales::sales_order',
                    'Magento_Sales::actions_view'
				  ];
        $this->rulesFactory->create()->setRoleId($role->getId())->setResources($resource)->saveRel();

        $checkRole = $this->justunorole->addFieldToFilter('role_name', ['eq' => 'justunoUser'] );
        $roleID = $checkRole->getFirstItem()->getRoleId();

        $UserInfo = [
            'username'  => 'justunouser',
            'firstname' => 'justuno',
            'lastname'  => 'user',
            'email'     => 'info123@justuno.com',
            'password'  => 'hello@123',
            'interface_locale' => 'en_US',
            'is_active' => 1
        ];

        $userModel = $this->_userFactory->create();
        $userModel->setData($UserInfo);
        $userModel->setRoleId($roleID);
        $userModel->save();
    }


}