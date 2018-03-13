<?php
/**
 * Created by PhpStorm.
 * User: casperlai
 * Date: 2016/11/9
 * Time: 上午8:41
 */

namespace Casperlaitw\LaravelFbMessenger\Messages;

use Casperlaitw\LaravelFbMessenger\Collections\ListElementCollection;
use Casperlaitw\LaravelFbMessenger\Contracts\Messages\Template;
use Casperlaitw\LaravelFbMessenger\Exceptions\ListElementCountException;
use Casperlaitw\LaravelFbMessenger\Transformers\ListTransformer;

/**
 * Class ListTemplate
 * @package Casperlaitw\Messages
 */
class ListTemplate extends Template
{
    /**
     * @var Button
     */
    private $button;

    /**
     * ListTemplate constructor.
     * @param $sender
     * @param array $elements
     */
    public function __construct($sender, $elements = [])
    {
        parent::__construct($sender);
        $this->add($elements);
    }

    /**
     * @return array
     * @throws ListElementCountException
     */
    public function toData()
    {
        $elements = $this->getCollections()->getElements();
        if (count($elements) < 2 || count($elements) > 5) {
            throw new ListElementCountException('At least 2 elements and at most 4 elements');
        }
        $payload = (new ListTransformer)->transform($this);
        $this->setPayload($payload);

        return parent::toData();
    }

    /**
     * Collection class name
     *
     * @return mixed
     */
    protected function collection()
    {
        return ListElementCollection::class;
    }

    /**
     * @return Button
     */
    public function getButton()
    {
        return $this->button;
    }

    /**
     * @param Button $value
     * @return $this
     */
    public function setButton(Button $value)
    {
        $this->button = $value;

        return $this;
    }
}
