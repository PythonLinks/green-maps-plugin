## Green Party Maps Plugin

Here is a plugin which displays the data from https://GreenMaps.Us on a local
WordPress web site. Green Maps is a map of the US green party. 

This software is currently under development and testing. Aug 1, 2025.
but it should be done in a few days.

The software needs a source for the underlying map data.  It currently uses mapbox for the data.  It includes a mapbox license key, but that key will not work on your site, unless it has been enabled.  Just ask.  

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

There needs to be a way to add your own key, for example for a state party.
