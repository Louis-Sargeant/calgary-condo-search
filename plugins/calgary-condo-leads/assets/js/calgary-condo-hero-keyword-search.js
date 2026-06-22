(function () {
  var explicitRoutes = [
    {
      url: '/southeast-calgary-condos/',
      terms: ['southeast', 'se', 'south east', 'southeast calgary', 'southeast condos', 'se calgary', 'se condos', 'south east calgary', 'south east condos']
    },
    {
      url: '/southwest-calgary-condos/',
      terms: ['southwest', 'sw', 'south west', 'southwest calgary', 'southwest condos', 'sw calgary', 'sw condos', 'south west calgary', 'south west condos']
    },
    {
      url: '/northwest-calgary-condos/',
      terms: ['northwest', 'nw', 'north west', 'northwest calgary', 'northwest condos', 'nw calgary', 'nw condos', 'north west calgary', 'north west condos']
    },
    {
      url: '/northeast-calgary-condos/',
      terms: ['northeast', 'ne', 'north east', 'northeast calgary', 'northeast condos', 'ne calgary', 'ne condos', 'north east calgary', 'north east condos']
    },
    {
      url: '/all-calgary-condos/',
      terms: ['calgary', 'calgary condos', 'all calgary condos', 'all condos', 'live calgary condos', 'search calgary condos', 'condos', 'citywide']
    },
    {
      url: '/under-400k/',
      terms: ['under 400k', 'under $400k', '400k']
    },
    {
      url: '/price-reduced/',
      terms: ['price reduced', 'reduced']
    },
    {
      url: '/building-alerts/',
      terms: ['building alerts', 'alerts']
    }
  ];

  function normalizeSearchTerm(value) {
    return (value || '')
      .toString()
      .toLowerCase()
      .replace(/[^a-z0-9\s]+/g, ' ')
      .replace(/\s+/g, ' ')
      .trim();
  }

  function termMatches(normalizedKeyword, term) {
    var escapedTerm = term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    var termPattern = new RegExp('(^|\\s)' + escapedTerm + '($|\\s)');

    return termPattern.test(normalizedKeyword);
  }


  function resolveKeywordRoute(keyword) {
    var normalizedKeyword = normalizeSearchTerm(keyword);

    if (!normalizedKeyword) {
      return '';
    }

    for (var routeIndex = 0; routeIndex < explicitRoutes.length; routeIndex += 1) {
      var route = explicitRoutes[routeIndex];

      for (var termIndex = 0; termIndex < route.terms.length; termIndex += 1) {
        if (termMatches(normalizedKeyword, route.terms[termIndex])) {
          return route.url;
        }
      }
    }

    return '';
  }

  function toAbsoluteUrl(pathOrUrl) {
    if (/^https?:\/\//i.test(pathOrUrl)) {
      return pathOrUrl;
    }

    return window.location.origin + pathOrUrl;
  }

  document.addEventListener('submit', function (event) {
    var form = event.target.closest('.ccl-keyword-search-form');

    if (!form) {
      return;
    }

    event.preventDefault();

    var input = form.querySelector('#ccl-hero-keyword-search');
    var keyword = input && input.value ? input.value.trim() : '';
    var route = resolveKeywordRoute(keyword);
    var baseUrl = form.getAttribute('action') || '/all-calgary-condos/';

    if (route) {
      window.location.href = toAbsoluteUrl(route);
      return;
    }

    if (baseUrl.indexOf('?') !== -1) {
      baseUrl = baseUrl.split('?')[0];
    }

    if (baseUrl.charAt(baseUrl.length - 1) !== '/') {
      baseUrl += '/';
    }

    window.location.href = toAbsoluteUrl(baseUrl);
  });
})();
