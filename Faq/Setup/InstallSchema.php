<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */

namespace Ceymox\Faq\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
      
        $installer->startSetup();
       
          if (!$installer->tableExists('ceymox_faq')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('ceymox_faq'))
         ->addColumn(
                    'faq_id',
                    Table::TYPE_INTEGER,
                    10,
                    ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true]
                )
                ->addColumn('question', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn('answer', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn('status', Table::TYPE_TEXT, 255, ['nullable' => false])
    
                ->setComment('FAQ table');

            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists('ceymox_faqproduct')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('ceymox_faqproduct'))
                ->addColumn('faq_id', Table::TYPE_INTEGER, 10, ['nullable' => false, 'unsigned' => true])
                ->addColumn('product_id', Table::TYPE_INTEGER, 10, ['nullable' => false, 'unsigned' => true], 'Magento Product Id')
                ->addForeignKey(
                    $installer->getFkName(
                        'ceymox_faq',
                        'faq_id',
                        'ceymox_faqproduct',
                        'faq_id'
                    ),
                    'faq_id',
                    $installer->getTable('ceymox_faq'),
                    'faq_id',
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'ceymox_faqproduct',
                        'faq_id',
                        'catalog_product_entity',
                        'entity_id'
                    ),
                    'product_id',
                    $installer->getTable('catalog_product_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE
                )
                ->setComment('Ceymoc FAQ Product Table');

            $installer->getConnection()->createTable($table);
        }


        $installer->endSetup();
    }
}
