<form role="search" method="get" class="header__search-form" action="<?php echo home_url( '/' ) ?>">
    <label>
        <span class="hide-content">Search for:</span>
        <input type="search" class="search-field" placeholder="Type Keywords" value="<?php echo get_search_query() ?>" name="s" title="Search for:" autocomplete="off">
    </label>
    <input type="submit" class="search-submit" value="Search">
</form>
<a href="#0" title="Close Search" class="header__overlay-close">Close</a>