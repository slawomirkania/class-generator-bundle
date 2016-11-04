<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib\Traits;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
trait MultilineCommentTrait
{

    /**
     * Collection of comment rows
     *
     * @Type("Doctrine\Common\Collections\ArrayCollection<string>")
     */
    private $multilineComment = null;

    /**
     * @return ArrayCollection
     */
    public function getMultilineComment()
    {
        if (is_null($this->multilineComment)) {
            return new ArrayCollection();
        }

        return $this->multilineComment;
    }

    /**
     * @param ArrayCollection $multilineComment
     */
    public function setMultilineComment(ArrayCollection $multilineComment)
    {
        $this->multilineComment = $multilineComment;
    }
}
