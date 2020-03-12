const searchClient = algoliasearch(algolia_object.app_id, algolia_object.search_api_key);

const posts = searchClient.initIndex(algolia_object.indices_name);
// #tie-popup-search-input
autocomplete('#aloglia-search-input', {}, [
    {
      // source: autocomplete.sources.hits(posts, { hitsPerPage: 5, facetFilters: 'post_type_label:Posts'}),
      source: autocomplete.sources.hits(posts, { hitsPerPage: 5 }),
      displayKey: 'name',
      templates: {
        // ${hit.images.thumbnail.url}
        footer({query, isEmpty }) { if(!isEmpty) { return `<div class="widget-post-list"><a class="button fullwidth" href=/?s=${query}&orderby=post_date&order=desc>View all results</a></div>`}},
        routing: true,
        empty: '<p class="info">No results were found with your current filters</p>',
        suggestion(hit) {
          return `<div class="autocomplete-suggestion">
          <div class="widget-post-list">
          ${hit.images.thumbnail && `
          <div class="post-widget-thumbnail">
            <img src=${hit.images.thumbnail.url} />
          </div>`}
          <div class="post-widget-body ">
            <a href=${hit.permalink} class="post-title">${hit._highlightResult.post_title.value}</a>
            <div class="post-meta">
              <span class="date meta-item fa-before">${hit.post_date_formatted}</span>
            </div>
	        </div>
         </div></div> `;
        }
      }
    },
]);