<?php

namespace Opifer\QueueIt\Redirect;

class RedirectType
{
    const Unknown = 0;
    const Queue = 1;
    const Safetynet = 2;
    const AfterEvent = 3;
    const Disabled = 4;
    const DirectLink = 5;

    /**
     * From string
     *
     * @param string $value
     *
     * @return integer
     */
    public static function FromString($value)
    {
        if ($value == null)
            return RedirectType::Unknown;
        if (strtolower($value) == 'queue')
            return RedirectType::Queue;
        if (strtolower($value) == 'safetynet')
            return RedirectType::Safetynet;
        if (strtolower($value) == 'afterevent')
            return RedirectType::AfterEvent;
        if (strtolower($value) == 'disabled')
            return RedirectType::Disabled;
        if (strtolower($value) == 'directlink')
            return RedirectType::DirectLink;
    }
}
