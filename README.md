# Usage

## Creating Installables from Pre-existing Components

*Note: "mycomponent" is only an example name, you can replace it with whatever you please.*

1. Create a new folder called *com_mycomponent* somewhere on your system.
2. Copy the following folders from your Joomla project into the *com_mycomponent* folder, renaming them as you go.

    | Folder                                   | Rename to |
    |------------------------------------------|-----------|
    | administrator/components/com_mycomponent | admin     |
    | components/com_mycomponent               | site      |
    | media/com_mycomponent                    | media     |

3. Move *mycomponent.xml* from the *admin* folder into the root of the *com_mycomponent* folder.
4. Zip it up.

The component can now be installed.

## Installing Components

1. Log in to the admin side of your Joomla 4 site.
2. In the left menu, navigate to *system* section.
3. Under *install*, select *Extensions*.
4. Drag and drop your package file (eg. *com_mycomponent.zip*) into the upload field.

To test if the install was successful, create a new menu. When selecting the *Menu Item Type*, your component name should be visible.