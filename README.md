## Green Party Maps Plugin

Here is a plugin which displays the data from https://GreenMaps.Us on a local
WordPress web site. Green Maps is a map of the US green party. 

This software is currently under development and testing. Aug 1, 2025.
but it should be done in a few days.

Still needs to automatically create the menu items.
Party
  -National
  -State
  -Local

It injects header, but not a footer.
It has a shortcode for the map html.

For security reasons, the Javascript needs to be loaded from local files
just the data should be loaded remotely.  But that also makes it harder to
evolve the javascript.   It needs to get tied into the whole WordPress update
your Plugin functionality. 