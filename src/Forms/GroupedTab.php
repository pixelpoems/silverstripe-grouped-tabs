<?php

namespace Pixelpoems\GroupedTabs\Forms;

use SilverStripe\Forms\TabSet;

class GroupedTab extends TabSet
{
    public function IsGrouped(): bool
    {
        return true;
    }

    public function getFirstChildId(): string
    {
        $first = $this->Tabs()->first();
        return $first ? $first->getAttribute('id') : '';
    }
}
