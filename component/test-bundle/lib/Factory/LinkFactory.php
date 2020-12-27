<?php

/*
 * Copyright (C) 2019 Mazarini <mazarini@protonmail.com>.
 * This file is part of mazarini/crud-bundle.
 *
 * mazarini/crud-bundle is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * mazarini/crud-bundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License
 */

namespace Mazarini\TestBundle\Factory;

use Mazarini\ToolsBundle\Data\Link;
use Mazarini\ToolsBundle\Data\Links;
use Mazarini\ToolsBundle\Data\LinkTree;

class LinkFactory
{
    public function getLinksSample(): Links
    {
        $links = new Links('#sample-2');
        for ($i = 1; $i <= 5; ++$i) {
            $key = sprintf('sample-%d', $i);
            if (2 === $i) {
                $link = new Link($key, '#'.$key, 'Active');
            } elseif (4 === $i) {
                $link = new Link($key, '#', 'Disable');
            } else {
                $link = new Link($key, '#'.$key);
            }
            $links->addLink($link);
        }

        return $links;
    }

    public function getTreeSample(): LinkTree
    {
        $tree = $this->getTree('Tree', 'item', 5);
        $tree['item-1'] = $item1 = $this->getTree('Item-1', 'item-1', 2);
        $item1['item-1-1'] = $this->getTree('Item-1-1', 'item-1-1', 3);
        $item1['item-1-2'] = $this->getTree('Item-1-2', 'item-1-2', 2);
        $tree['item-2'] = $this->getTree('Item-2', 'item-2', 2);
        $tree['item-4'] = $this->getTree('Item-4', 'item-4', 2);

        return $tree;
    }

    private function getTree(string $label, string $name, int $count = 5): LinkTree
    {
        $tree = new LinkTree($name, $label);
        $name .= '-';
        for ($i = 1; $i <= $count; ++$i) {
            $key = $name.$i;
            $tree->addLink(new Link($key, '#'.$key));
        }

        return $tree;
    }
}
