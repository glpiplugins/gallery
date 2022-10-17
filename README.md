# Gallery Plugin for GLPI

This plugin adds a gallery to any asset.

## Assign rights

1. Go to `Setup > Profiles`, select your wanted profile and select tab `Galleries`
2. Select all rights
3. Click `Save` 

## How to configure

1. Go to `Setup > Gallery`
2. Add the asset types to the image config

![alt text](/pic/gallery_config.PNG)

3. Click `Save`

## How to upload

1. Go to any asset (type must be configured see 'How to configure')
2. Select tab `Gallery`
3. Upload one or more image
4. Wait for the upload to complete
5. Click `Save`

The image(s) should be now available underneath the upload form.

## Panorama images and VR-View
As a little bonus, you can upload 360 degrees panorama images (must be spherical) to view it as a vr image. It is useful for Locations to have a nice overview.

Note: If the image format is 2:1 (which is the case for vr images), the plugin will automatically render the given image in a vr viewer.

## Example

![alt text](/pic/gallery.gif)

## Contributing

* Open a ticket for each bug/feature so it can be discussed
* Follow [development guidelines](http://glpi-developer-documentation.readthedocs.io/en/latest/plugins/index.html)
* Refer to [GitFlow](http://git-flow.readthedocs.io/) process for branching
* Work on a new branch on your own fork
* Open a PR that will be reviewed by a developer

## Copying

* **Code**: you can redistribute it and/or modify it under the terms of the GNU General Public License ([GPL-3.0](https://www.gnu.org/licenses/gpl-3.0)).