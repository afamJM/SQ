
    <form method="get" action="/search/" class="small-8 large-4  column small-centered large-centered">
        <div>
            <img src="/wp-content/themes/Ibiza-Theme/assets/images/search-icon.png" title="Search icon" alt="Search icon" />
            <input title="Search for:" value="<?php print $search; ?>" name="q" class="search-field typeahead  tt-hint" autocomplete="off" spellcheck="false" tabindex="-1" dir="ltr" type="search">
            <input type="hidden" name="type" value="product" />
            <button type="submit"><img src="http://ibiza.com.dev/wp-content/themes/Ibiza-Theme/assets/images/Btn_Submit.svg" /></button>
                   
        </div>
    </form>
    