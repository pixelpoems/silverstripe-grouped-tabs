<?php

namespace Pixelpoems\GroupedTabs\Admins;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Model\ArrayData;
use SilverStripe\Model\List\ArrayList;
use SilverStripe\ORM\DataObject;

/**
 * Usage:
 * class CrochetAdmin extends GroupedModelAdmin
 * ToDO: Add Usage of $managed_models
 */
abstract class GroupedModelAdmin extends ModelAdmin
{
    public function getManagedModels(): array
    {
        $models = $this->config()->get('managed_models');
        if (is_string($models)) {
            $models = [$models];
        }
        if (!count($models ?? [])) {
            throw new \RuntimeException(
                'ModelAdmin::getManagedModels():
                You need to specify at least one DataObject subclass in private static $managed_models.
                Make sure that this property is defined, and that its visibility is set to "private"'
            );
        }

        foreach ($models as $k => $v) {
            if (is_numeric($k)) {
                $models[$v] = ['dataClass' => $v, 'title' => singleton($v)->i18n_plural_name()];
                unset($models[$k]);
            } elseif (is_array($v) && isset($v['dataClasses']) && is_array($v['dataClasses'])) {
                $groupTitle = _t(static::class . '.' . $k, $v['title'] ?? $k);
                $classes = $v['dataClasses'];
                foreach ($classes as $k2 => $v2) {
                    $models[$v2] = ['dataClass' => $v2, 'title' => singleton($v2)->i18n_plural_name(), 'group' => $groupTitle];
                }
                unset($models[$k]);
            } elseif (is_array($v) && !isset($v['dataClass'])) {
                $models[$k]['dataClass'] = $k;
            } elseif (is_a($v, DataObject::class, true)) {
                $models[$k] = ['dataClass' => $v, 'title' => singleton($v)->i18n_plural_name()];
            }
        }

        return $models;
    }

    protected function getManagedModelTabs(): ArrayList
    {
        $models = $this->getManagedModels();
        $forms = new ArrayList();
        $groupItems = [];

        foreach ($models as $tab => $options) {
            $group = $options['group'] ?? null;
            $isCurrent = ($tab === $this->modelTab);

            if ($group === null) {
                $forms->push(new ArrayData([
                    'IsGroup' => false,
                    'Title' => $options['title'],
                    'Tab' => $tab,
                    'ClassName' => $options['dataClass'] ?? $tab,
                    'Link' => $this->getLinkForModelTab($tab),
                    'LinkOrCurrent' => $isCurrent ? 'current' : 'link',
                ]));
            } else {
                if (!isset($groupItems[$group])) {
                    $groupItems[$group] = new ArrayList();
                    $forms->push(new ArrayData([
                        'IsGroup' => true,
                        'Title' => $group,
                        'Items' => $groupItems[$group],
                        'LinkOrCurrent' => 'link',
                        'FirstLink' => $this->getLinkForModelTab($tab),
                    ]));
                }
                $groupItems[$group]->push(new ArrayData([
                    'Title' => $options['title'],
                    'Tab' => $tab,
                    'ClassName' => $options['dataClass'] ?? $tab,
                    'Link' => $this->getLinkForModelTab($tab),
                    'LinkOrCurrent' => $isCurrent ? 'current' : 'link',
                ]));
            }
        }

        // Mark group as active if any child is current
        foreach ($forms as $item) {
            if ($item->IsGroup && $item->Items->find('LinkOrCurrent', 'current')) {
                $item->LinkOrCurrent = 'current';
            }
        }

        return $forms;
    }
}
