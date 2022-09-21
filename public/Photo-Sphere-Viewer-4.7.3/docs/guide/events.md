# Events

[[toc]]

## Presentation

Photo Sphere Viewer uses [uEvent API](https://github.com/mistic100/uEvent#uevent). The full list of events is available on the <ApiLink page="PSV.html#.event:autorotate"/>.

Event listeners take an `Event` object as first parameter, this object is generally not used. Other parameters are available after this event object.

## Main events

This section describes the most useful events available.

### `click(data)` | `dblclick(data)`

Triggered when the user clicks on the viewer (excluding the navbar and the side panel), it contains many information about where the user clicked including a [marker](../plugins/plugin-markers.md) if the `clickEventOnMarker` option is enabled.

```js
viewer.on('click', (e, data) => {
  console.log(`${data.rightclick?'right ':''}clicked at longitude: ${data.longitude} latitude: ${data.latitude}`);
});
```

A `click` event is always fired before a `dblclick`.

### `position-updated(position)`

Triggered when the view longitude and/or latitude changes.

```js
viewer.on('position-updated', (e, position) => {
  console.log(`new position is longitude: ${position.longitude} latitude: ${position.latitude}`);
});
```

### `ready`

Triggered when the panorama image has been loaded and the viewer is ready to perform the first render.

```js
viewer.once('ready', () => {
  console.log(`viewer is ready`);
});
```

### `zoom-updated(level)`

Triggered when the zoom level changes.

```js
viewer.on('zoom-updated', (e, level) => {
  console.log(`new zoom level is ${level}`);
});
```
