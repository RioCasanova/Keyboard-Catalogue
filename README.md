# Keyboard-Catalogue
Final project in PHP and using MariaDb that catalogues custom keyboards

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

  
  ## Requirements
  
complete the /admin/ section of your catalog where a new item can be inserted, edited, and deleted. 

Admin section must be secured using a sessions based login script.   
**username:** admin    
**password:** Password1!

In order to test that a new item can be inserted, I will also ask for some kind of rough output page to be shown just so that we can see a new item has been inserted successfully and that all data and imagery is present (we must be able to see an image thumbnail) . Design, filtering, features, etc, are not a factor for this rough output. 

Design and usability (proper validation, form alignment, etc.) is a factor for the admin section. Validation must be PHP and not browser validation. 
