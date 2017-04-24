<?php

namespace SimpleEntityGeneratorBundle\Lib\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
interface MultilineCommentableInterface
{

    /**
     * @return ArrayCollection
     */
    public function getMultilineComment();

    /**
     * @param ArrayCollection $multilineComment
     */
    public function setMultilineComment(ArrayCollection $multilineComment);
}
