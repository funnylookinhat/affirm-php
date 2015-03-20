# affirm-php
Affirm PHP Library.

## Installation

You can install affirm-php through composer.  Note that the version you request 
is directly tied to the version of the API it expects ( i.e. 2.x.x is for v2 
of the API ).  Extremely bleeding edge development is tagged at a prepended 0. - 
so the bleeding edge for v2 is 0.2.x.x.

```
{
  "require": {
    "funnylookinhat/affirm-php": "0.2.*"
  }
}
```

## Usage

Right now there's only one API-endpoint for Affirm's service offering - 
charges.  Coincidentally, there is only one major interaction class for this 
library.

Before anything, you have to initialize the library.

```
Affirm\Resource::Init(
	'public-key',
	'private-key',
	'product-key',
	'https://sandbox.affirm.com/api/v2'
);
```

Passing the URL is optional - as the library will default to the live API if 
nothing else is provided.

### Charge

All end-points mirror the documented API: (http://docs.affirm.com/v2/api/charges/)[http://docs.affirm.com/v2/api/charges/]
They return the decoded object that is documented there - in most cases that is
a Charge ( or an Event that is appended to the Charge ).


**Get**

```
$affirm_charge = Affirm\Resource::Get(array(
	'id' => "ASDF-HJKL",
));
```

**Create**

```
$affirm_charge = Affirm\Resource::Create(array(
	'checkout_token' => "jibberjabber",
));
```

**Capture**


```
$affirm_charge = Affirm\Resource::Capture(array(
	'id' => "ASDF-HJKL",
	'order_id' => "ASDF-HJKL",
	'shipping_carrier' => "UPS",
	'shipping_confirmation' => "1Z9999999999999999",
));
```

**Void**


```
$affirm_event = Affirm\Resource::Void(array(
	'id' => "ASDF-HJKL",
));
```

**Refund**

```
$affirm_event = Affirm\Resource::Refund(array(
	'id' => "ASDF-HJKL",
	'amount' => 12345,
));
```

