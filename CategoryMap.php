<?php
/**
 * Import Definitions.
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2016-2018 w-vision AG (https://www.w-vision.ch)
 * @license    https://github.com/w-vision/ImportDefinitions/blob/master/gpl-3.0.txt GNU General Public License version 3 (GPLv3)
 */

namespace ImportDefinitionsBundle\Interpreter;

use ImportDefinitionsBundle\Model\DefinitionInterface;
use ImportDefinitionsBundle\Model\Mapping;
use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Concrete;

class CategoryMap implements InterpreterInterface
{
    /**
     *{@inheritdoc}
     */
    public function interpret(Concrete $object, $value, Mapping $map, $data, DefinitionInterface $definition, $params, $configuration) {
        $objectId = $configuration['objectId'];
        
        if(!empty($data['Category'])){
            $categoryListObject =\Pimcore\Model\DataObject::getByPath("/All Items/PIM-Category/")->getChildren();
            if(!empty($categoryListObject)){
                $found = false;
                foreach($categoryListObject as $e){ 
                    $id = $e->get('o_id'); 
                    $categoryObject = DataObject\Category::getById($id); 
                    if($categoryObject){
                        $shortName = $categoryObject->getCat_short_code();
                        if($data['Category']== $shortName){
                            $found=true;
                            return DataObject::getById($categoryObject->getId());                            
                        }
                    } 
                }
                if($found==false){return DataObject::getById(243);}
            }
        }else{
            return DataObject::getById(243);
        }
    }
    
}
