# Project Name

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/stedop/starcitizens/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/stedop/starcitizens/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/stedop/starcitizens/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/stedop/starcitizens/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/stedop/starcitizens/badges/build.png?b=master)](https://scrutinizer-ci.com/g/stedop/starcitizens/build-status/master)

A StarCitizen API wrapper.  Utilises the API from http://sc-api.com

## Installation

You can install this framework with Composer just install Composer and then type

    composer require stedop/starcitizen ~1.0

into the command line at your project root and you're good to

## Usage

To get information

    use StarCitizen\Accounts\Accounts;
    
    $profile = Accounts::findProfile(<userName>);
    $threads = Accounts::findThreads(<userName>);
    $posts = Accounts::findPosts(<userName>);
    
### Loading any other objects after loading

If you want to get a profiles' latest posts or threads
 
    $profile = Accounts::findProfile(<userName>);
    
    /*
        ...some code
    */
    
    $posts = $profile->posts;
    $threads = $profile->threads;

This returns the posts or threads or you don't have to assign the posts or thread to a var, simply use

    foreach ($profile->posts as $post) {
        // ....your code
    }
    
### Eager loading

If you wanted to load the objects when you find the profile

    $profile = Accounts::findProfile(<userName>)->with('posts', 'threads');


### Extending

All of the core find classes are final but every model is extensible.  This will allow you to create your own logic for each model.

[For example, using the Profile model](https://github.com/stedop/starcitizens/blob/master/src/Examples/ExtensionExample.php)
 
Please review the code for further information  

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D


## Credits

Thanks to [Siegen](https://robertsspaceindustries.com/citizens/Siegen) on the RSI forums for building the API (I'm so glad I didn't have to)

## License

 This project is licensed under the terms of the MIT license.
 
 Copyright (c) 2015 Stephen Dop
 
 Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 
 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 
 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.