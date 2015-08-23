# Wordsmith Sidebar Widget

This is a very small WordPress sidebar widget that adds the word of the day 
from [Wordsmith.org](http://wordsmith.org) to your site.

### Settings

There aren't any. 

The only real options are the URL to the Wordsmith feed and the length of time 
that WordPress stores a transient of the feed. It defaults to an hour. If you
want to change that you'll need to edit the PHP.

### Styling

Again, not any aside from a CSS class wrapped around everything.

The HTML output looks like this.

    <div class="widget-text ws-wrapper">
    <h3>The Word</h3>
    <p>The definition of the word</p>
    </div>

The whole thing is wrapped in a div with the class `ws-wrapper`. You're probably 
going to want to style from that. Otherwise it will be a very boring block of
text. 