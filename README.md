# WordPress Facet Filtering
A WordPress Facet Filtering Plugin which generates archive page filters that empower site users to express complex queries through a familiar and intuitive UI.

# Administration
Site admins control how each facet set is filtered, which controls how the filter is visuaized.

Site admins select which post to apply

# 08-26-19 Update:

Starting to wrap my head around the basic concepts that will allow me to validate my architechture.

I need to be able to turn the basic WordPress structure upside down in order to get facet like behavior.

For each term, I will generate an array of post IDs (facet set) and store it in the term-meta table.

For each taxonomy I will set a filter strategy (range, pick one, pick many, pick n) and will have to store that in the wp_options table

I'll need to be able to recall filter strategies by taxonomy, so a function to get that because a user sets a filter, I need to know which items to look at, and how to compare them. 

So the option they select will determine the facet_set, and the select field itself will determine the strategy

# TODOs

* Add Select2
* Find Slider Library
* Frontend design
* Finish entering test data set: THANKS JEFF!