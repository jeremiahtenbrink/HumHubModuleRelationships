# Relationships Module

HumHub module so users can incorporate relationships with other users. 

Profile Image:
![Profile Image](https://github.com/jeremiahtenbrink/relationships/blob/master/resources/screen-shots/Profile.JPG "Profile View")

Profile Image viewed by person in the relationship. 
![Profile Image](https://github.com/jeremiahtenbrink/relationships/blob/master/resources/screen-shots/ProfileViewAsAnotherPerson.JPG "Profile View")

# Instructions

Copy relationship module into the modules directory. 

Then enable the module and in the admin section add a category and some relationship types. 
![Admin Add Types](https://github.com/jeremiahtenbrink/relationships/blob/master/resources/screen-shots/AdminCreateType.JPG "Create Relationship Types")

Then add the relationship widget to the profile view file in the themes folder. 

First Add this code to the top under all of the other use statmens. 

```
use humhub\modules\relationships\widgets\Relationships;
```

Then add the following code to the view file just under the div class="col-xs-12 col-md-8 layout-content-container". 

```
<?= Relationships::widget(['user' => $user]); ?>
```

View File Should Look Like this below. 

![Code](https://github.com/jeremiahtenbrink/relationships/blob/master/resources/screen-shots/Code.JPG "Code Example")
