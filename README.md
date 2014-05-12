# Module MoreInfos Thelia 2

This module allows your visitors to ask you more information about a product in your catalog.

## How to install

This module must be into your ```modules/``` directory (thelia/local/modules/).

You can download the .zip file of this module or create a git submodule into your project like this :

```
cd /path-to-thelia
git submodule add https://github.com/thelia-modules/moreinfos.git local/modules/MoreInfos
```

Next, go to your Thelia admin panel for module activation.

## How to configure

This module will create a configuration variable named ```moreinfos-email```, it corresponds to the reception email address of requests sent.
You can enter email address in the configuration variables of Thelia.

## How to use

This module will provide a contact form already developed, you just need to built it into your template.

```html
{form name="front.moreinfos.send"}
    <form action="{url path='/more-infos/send'}" method="post">
        {form_hidden_fields form=$form}

        {form_field form=$form field="return_url"}
            <input name="{$name}" type="hidden" value="{navigate to='current'}">
        {/form_field}

        {form_field form=$form field="product"}
            <input name="{$name}" type="hidden" value="{$REF} - {$TITLE}"> {* The ref and title of product which will be added to the email subject *}
        {/form_field}

        {form_field form=$form field="email"}
            <div class="form-group">
                <label class="control-label" for="{$label_attr.for}">{$label} :</label>
                <input type="email" name="{$name}" class="form-control" id="{$label_attr.for}" value="{$value}" autofocus="autofocus" {if $required} aria-required="true" required{/if}>
            </div>
        {/form_field}

        {form_field form=$form field="message"}
            <div class="form-group">
                <label class="control-label" for="{$label_attr.for}">{$label} :</label>
                <textarea name="{$name}" class="form-control" id="{$label_attr.for}" rows="5" {if $required} aria-required="true" required{/if}>{$value}</textarea>
            </div>
        {/form_field}

        <button type="submit" class="btn btn-primary">{intl l="Send"}</button>
    </form>
{/form}
```