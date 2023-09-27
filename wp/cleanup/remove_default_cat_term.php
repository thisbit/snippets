<?php

function exclude_category($terms, $taxonomies, $args)
{
	foreach ($terms as $key => $term) 
	{
		if (is_object($term)) 
		{
			if ('uncategorized' == $term->slug && $term->taxonomy == 'category') 
			{
				unset($terms[$key]);
			}
		}
	}
	return $terms;
}
add_filter('get_terms', 'exclude_category', 10, 3);