# Keyboard-Catalogue
Final project in PHP and using MariaDb that catalogues custom keyboards

## Submission Requirements
    URL to main page.
    a list of features you have incorporated (in point form) . Do not include expected features (examples: secure login, uploading image, etc.), but do include unique features to this project.
    please list the three or more ways I can filter your items.

## Please upload a ZIP file containing:

    the entire project folder . You can remove the /images/originals/ folder to make for a smaller upload.
    the exported database table(s)

## Rubric: /20

    Filters: /7
        3 minimum
        ONE should be a BETWEEN query
    Content: /7
        minimum 25 items; all should have pics.
        Should have a home page describing the project and perhaps some feature items, interesting use of content (random, etc.) 
    Features/UX: /6
    
## Step 1 - Research
Input 25 or more items in the catalogue - or write down 25 keyboards that I would want to include or add to the database.

### Values - Columns or Attributes of a Keyboard
Keyboards      
  **keyboard_id** - int  
  **name** - string (Leobog Hi75)  
  **brand** - string (Leobog)  
  **RGB** - bool (yes)  
  **LED** - string (southfacing)  
  **size** - string (65 percent, 70 percent)  
  **case_material** - string (Aluminum)  
  **color** - string (white)   
  **price** - int (199.00)  
  **connectivity** - string (bluetooth, 2.4, usb-c)  
  **image** - string (url)  
  **site** - string (url where can purchase)

### Filters
Not filtering by color because of how much color can vary with each board
- brand
- RGB
- LED
- size
- price
- connectivity
  
### Chosen Keyboards

 1. **Leobog Hi75**  
 2. **Zoom 75**  
 3. **Zoom 65**  
 4. **Zoom 98**  
 5. **QK75N**  
 6. **GMKPro**  
 7. **GMK67**  
 8. **IK75**  
 9. **GK61**  
 10. **Feker K75**  
 11. **Summit 65**  
 12. **Mojo60**   
 13. **Mojo84**  
 14. **Modern97**  
 15. **MelGeek Pixel**  
 16. **Mojo68**  
 17. **Flesports MK870**  
 18. **Keebmonkey WK870**  
 19. **Drop Cyboard**  
 20. **Lofree Block 98**  
 21. **Feker Alice 98**  
 22. **Lofree Loflick**  
 23. **Machenike KT68**  
 24. **Ajazz AK820**  
 25. **Akko Mod007**  
  
  ## Requirements
  
complete the /admin/ section of your catalog where a new item can be inserted, edited, and deleted. 

Admin section must be secured using a sessions based login script.   
**username:** admin    
**password:** Password1!

- Single item page with full-sized image
- Rough Gallery page with thumbnails
- Login Page
- Edit/Delete page
- Add Page

In order to test that a new item can be inserted, I will also ask for some kind of rough output page to be shown just so that we can see a new item has been inserted successfully and that all data and imagery is present (we must be able to see an image thumbnail) . Design, filtering, features, etc, are not a factor for this rough output. 

Design and usability (proper validation, form alignment, etc.) is a factor for the admin section. Validation must be PHP and not browser validation. 

## Clarifications 


images: resize and copy the image and that is what will be stored and displayed to the user  
picture dimensions: width and height are up to use - create multiple folders with different sizes  
edit page: you dont have to add a picture on the edit page or add and if statement that says if nothing is added use what it has  
single item display: required  
validation: should be included  

## Notes:
I wont be closing any of the issues that I have on this project so that I can demonstrate my process and for future reference just for myself.

I want to be able to integrate a youtube video on the website, so the user doesnt have to go to youtube to watch it, I also want the user to be able to upload their own youtube video that displays the functionality of the keyboard that they are uploading.
