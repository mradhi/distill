<?php

/*
 * This file is part of the Distill package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Distill\Method\Command;

use Distill\Format;

/**
 * Extracts files from cpio archives.
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class Cpio extends AbstractCommandMethod
{
    /**
     * {@inheritdoc}
     */
    public function extract($file, $target, Format\FormatInterface $format)
    {
        $this->checkSupport($format);

        $this->getFilesystem()->mkdir($target);

        $command = sprintf("cd %s && cpio -idv -F %s", escapeshellarg($target), escapeshellarg($file));
        $exitCode = $this->executeCommand($command);

        return $this->isExitCodeSuccessful($exitCode);
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported()
    {
        if (null === $this->supported) {
            $this->supported = $this->existsCommand('cpio');
        }

        return $this->supported;
    }

    /**
     * {@inheritdoc}
     */
    public static function getClass()
    {
        return get_class();
    }

    public function isFormatSupported(Format\FormatInterface $format = null)
    {
        return $format instanceof Format\Simple\Cpio;
    }
}
