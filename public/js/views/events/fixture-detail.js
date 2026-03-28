document.addEventListener('DOMContentLoaded', function () {
  var livePanel = document.querySelector('[data-live-panel]');
  var input = document.getElementById('yt-live-url');
  var message = document.getElementById('yt-live-message');
  var embed = document.getElementById('yt-live-embed');
  var frame = document.getElementById('yt-live-frame');
  var openLink = document.getElementById('yt-live-open-link');

  if (!livePanel || !message || !embed || !frame || !openLink) return;

  function safeParseUrl(rawValue) {
    try {
      return new URL(rawValue);
    } catch (error) {
      return null;
    }
  }

  function sanitizeId(value) {
    return (value || '').split('?')[0].split('&')[0].replace(/[^\w-]/g, '');
  }

  function resolveYouTube(rawValue, parsed) {
    var plainId = sanitizeId((rawValue || '').trim());
    if (/^[a-zA-Z0-9_-]{11}$/.test(plainId)) {
      return {
        platform: 'YouTube',
        embedUrl: 'https://www.youtube.com/embed/' + plainId + '?autoplay=1&rel=0&modestbranding=1',
        sourceUrl: 'https://www.youtube.com/watch?v=' + plainId
      };
    }

    if (!parsed) return null;

    var host = parsed.hostname.replace(/^www\./, '');
    if (!(host === 'youtu.be' || host.includes('youtube.com'))) return null;

    var videoId = '';
    if (host === 'youtu.be') {
      videoId = sanitizeId(parsed.pathname.split('/').filter(Boolean)[0] || '');
    } else {
      videoId = sanitizeId(parsed.searchParams.get('v') || '');
      if (!videoId) {
        var pathParts = parsed.pathname.split('/').filter(Boolean);
        ['embed', 'live', 'shorts'].forEach(function (key) {
          var keyIndex = pathParts.indexOf(key);
          if (!videoId && keyIndex >= 0 && pathParts[keyIndex + 1]) {
            videoId = sanitizeId(pathParts[keyIndex + 1]);
          }
        });
      }
    }

    if (!videoId) return null;

    return {
      platform: 'YouTube',
      embedUrl: 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0&modestbranding=1',
      sourceUrl: parsed.toString()
    };
  }

  function resolveFacebook(parsed) {
    if (!parsed) return null;
    var host = parsed.hostname.replace(/^www\./, '');
    if (!(host.includes('facebook.com') || host === 'fb.watch')) return null;

    var sourceUrl = parsed.toString();
    return {
      platform: 'Facebook',
      embedUrl: 'https://www.facebook.com/plugins/video.php?href=' + encodeURIComponent(sourceUrl) + '&show_text=false',
      sourceUrl: sourceUrl
    };
  }

  function resolveInstagram(parsed) {
    if (!parsed) return null;
    var host = parsed.hostname.replace(/^www\./, '');
    if (!host.includes('instagram.com')) return null;

    var parts = parsed.pathname.split('/').filter(Boolean);
    if (parts.length < 2) return null;

    var type = parts[0];
    var shortcode = sanitizeId(parts[1]);
    if (!shortcode || ['p', 'reel', 'tv'].indexOf(type) === -1) return null;

    var sourceUrl = 'https://www.instagram.com/' + type + '/' + shortcode + '/';
    return {
      platform: 'Instagram',
      embedUrl: sourceUrl + 'embed/',
      sourceUrl: sourceUrl
    };
  }

  function resolveTikTok(parsed) {
    if (!parsed) return null;
    var host = parsed.hostname.replace(/^www\./, '');
    if (!host.includes('tiktok.com')) return null;

    var parts = parsed.pathname.split('/').filter(Boolean);
    var videoId = '';
    var videoIndex = parts.indexOf('video');

    if (videoIndex >= 0 && parts[videoIndex + 1]) {
      videoId = sanitizeId(parts[videoIndex + 1]);
    } else if (parts[0] === 'v' && parts[1]) {
      videoId = sanitizeId(parts[1]);
    }

    if (!videoId) return null;

    return {
      platform: 'TikTok',
      embedUrl: 'https://www.tiktok.com/embed/v2/' + videoId,
      sourceUrl: parsed.toString()
    };
  }

  function resolveEmbed(rawValue) {
    var value = (rawValue || '').trim();
    if (!value) return null;

    var parsed = safeParseUrl(value);
    return resolveYouTube(value, parsed) || resolveFacebook(parsed) || resolveInstagram(parsed) || resolveTikTok(parsed);
  }

  function hideLive() {
    frame.src = '';
    embed.classList.remove('is-active');
    openLink.style.display = 'none';
    openLink.removeAttribute('href');
  }

  function renderLive(urlValue) {
    var embedData = resolveEmbed(urlValue);

    if (!embedData) {
      hideLive();
      message.textContent = 'No pude leer ese enlace. Usa un link valido de YouTube, Facebook, Instagram o TikTok.';
      return;
    }

    frame.src = embedData.embedUrl;
    embed.classList.add('is-active');
    message.textContent = 'Transmision cargada desde ' + embedData.platform + '.';
    openLink.href = embedData.sourceUrl;
    openLink.style.display = 'inline-flex';
  }

  var persistedUrl = livePanel.dataset.liveUrl || '';
  if (input && !input.value && persistedUrl) {
    input.value = persistedUrl;
  }

  if (persistedUrl) {
    renderLive(persistedUrl);
  } else {
    hideLive();
    message.textContent = 'Aun no hay transmision en vivo disponible para este partido.';
  }
});
