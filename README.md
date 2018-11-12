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

To do this add the following code to the file. 

```
<?= Relationships::widget(['user' => $user]); ?>
```

View File Should Look Like this below. 

![Code](https://github.com/jeremiahtenbrink/relationships/blob/master/resources/screen-shots/Code.JPG "Code Example")
