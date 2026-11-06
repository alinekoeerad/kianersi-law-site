// Micro Analytics Tracker (Zero performance impact)
export type AnalyticsEventType = 'page_view' | 'phone' | 'instagram' | 'eitaa' | 'bale' | 'rubika' | 'maps';

export function trackEvent(eventType: AnalyticsEventType) {
  try {
    const data = JSON.stringify({ event: eventType });
    // Prefer sendBeacon for non-blocking asynchronous transmission
    if (navigator.sendBeacon) {
      navigator.sendBeacon('./admin/api.php?action=track_event', data);
    } else {
      fetch('./admin/api.php?action=track_event', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: data,
        keepalive: true
      }).catch(() => {});
    }
  } catch (e) {
    // Fail silently without affecting user experience
  }
}
