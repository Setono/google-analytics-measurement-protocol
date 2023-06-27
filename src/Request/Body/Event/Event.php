<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event;

use Setono\GoogleAnalyticsMeasurementProtocol\Request\Body\Event\Traits\HasSessionId;
use Setono\GoogleAnalyticsMeasurementProtocol\Request\Request;

// todo add validate method
abstract class Event
{
    use HasSessionId;

    public const ECOMMERCE_EVENTS = [
        AddPaymentInfoEvent::NAME,
        AddShippingInfoEvent::NAME,
        AddToCartEvent::NAME,
        BeginCheckoutEvent::NAME,
        PurchaseEvent::NAME,
        RemoveFromCartEvent::NAME,
        ViewCartEvent::NAME,
        ViewItemEvent::NAME,
        ViewItemListEvent::NAME,
    ];

    /**
     * MUST return the event name, e.g. add_to_cart, purchase etc
     * See https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events for an event reference
     */
    abstract public function getEventName(): string;

    /**
     * Returns the event parameters
     */
    abstract protected function getParameters(): array;

    /**
     * Returns true if the event is an ecommerce event
     */
    public function isEcommerceEvent(): bool
    {
        return in_array($this->getEventName(), self::ECOMMERCE_EVENTS, true);
    }

    /**
     * @param string $trackingContext Indicates whether this event should be treated as a server side or client side event
     */
    public function getPayload(string $trackingContext = Request::TRACKING_CONTEXT_SERVER_SIDE): array
    {
        if (Request::TRACKING_CONTEXT_SERVER_SIDE === $trackingContext) {
            return [
                'name' => $this->getEventName(),
                'params' => array_filter($this->getParameters()),
            ];
        }

        if (Request::TRACKING_CONTEXT_CLIENT_SIDE_TAG_MANAGER === $trackingContext) {
            if ($this->isEcommerceEvent()) {
                return [
                    'event' => $this->getEventName(),
                    'ecommerce' => array_filter($this->getParameters()),
                ];
            }

            $parameters = array_filter($this->getParameters());
            $parameters['event'] = $this->getEventName();

            return $parameters;
        }

        return array_filter($this->getParameters());
    }
}
