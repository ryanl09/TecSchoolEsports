var adminurl = 'https://tecleagues.com/wp-admin/admin-ajax.php';
var pagecontent = '';

let obj = (name) => {
    return document.getElementById(name);
}

function removepfp() {
    $.ajax({
        type:'post',
        url:adminurl,
        data:{action:'remove_pfp'},
        dataType: 'text',
        success:function(response) {
            if(response.startsWith('[Success]')) {
                response = response.replace('[Success] ', '');
                obj('displaypfp').remove();
                alertify.set({ delay: 5000 }); 
                alertify.success(response); 
            } else if (response.startsWith('[Error]')) {
                response = response.replace('[Error] ', '')
                alertify.set({ delay: 5000 }); 
                alertify.error(response); 

            } else {
                alertify.set({ delay: 5000 }); 
                alertify.success(response); 
            }
        },
        error:function(xhr,response,error) {
            alertify.set({ delay: 5000 }); 
            alertify.error(response);
        }
    });
}

$(document).ready(function() {
    if (stuff.content) {
        obj('playerpagecontent').value = stuff.content;
        pagecontent = stuff.content;
    }
    var bgcolor=obj('bgcolor-picker');
    var textcolor=obj('textcolor-picker');
    var headercolor=obj('headercolor-picker');
    var menucolor=obj('menucolor-picker');
    var linkcolor=obj('linkcolor-picker');
    var linkhovercolor=obj('linkhovercolor-picker');
    //var isvisual=obj('isvisual');
    try {
        if (stuff.bgcolor) {
            bgcolor.value=stuff.bgcolor;
            obj('bgcolor').value=stuff.bgcolor;
        }
        if (stuff.textcolor) {
            textcolor.value=stuff.textcolor;
            obj('textcolor').value=stuff.textcolor;
        }
        if(stuff.headercolor) {
            headercolor.value=stuff.headercolor;
            obj('headercolor').value=stuff.headercolor;
        }
        if (stuff.menucolor) {
            menucolor.value=stuff.menucolor;
            obj('menucolor').value=stuff.menucolor;
        }
        if (stuff.linkcolor) {
            linkcolor.value=stuff.linkcolor;
            obj('linkcolor').value=stuff.linkcolor;
        }
        if (stuff.linkhovercolor) {
            linkhovercolor.value=stuff.linkhovercolor;
            obj('linkhovercolor').value=stuff.linkhovercolor;
        }
    } catch (e) {

    }

    bgcolor.onchange = (event) => {
        obj('bgcolor').value = bgcolor.value;
    }
    bgcolor.oninput = (event) => {
        obj('bgcolor').value = bgcolor.value;
    }

    textcolor.onchange = (event) => {
        obj('textcolor').value = textcolor.value;
    }
    textcolor.oninput = (event) => {
        obj('textcolor').value = textcolor.value;
    }

    headercolor.oninput = (event) => {
        obj('headercolor').value = headercolor.value
    }
    headercolor.onchange = (event) => {
        obj('headercolor').value = headercolor.value
    }

    menucolor.oninput = (event) => {
        obj('menucolor').value = menucolor.value;
    }
    menucolor.onchange = (event) => {
        obj('menucolor').value = menucolor.value;
    }

    linkcolor.oninput = (event) => {
        obj('linkcolor').value = linkcolor.value;
    }
    linkcolor.onchange = (event) => {
        obj('linkcolor').value = linkcolor.value;
    }

    linkhovercolor.oninput = (event) => {
        obj('linkhovercolor').value = linkhovercolor.value;
    }
    linkhovercolor.onchange = (event) => {
        obj('linkhovercolor').value = linkhovercolor.value;
    }

    /*
    isvisual.onchange = () => {
        if (isvisual.checked) {
            pagecontent = obj('playerpagecontent').value;
            obj('pagewpr').innerHTML = pagecontent;
        } else {
            obj('pagewpr').innerHTML = '<textarea height="500" id="playerpagecontent"></textarea>';
            obj('playerpagecontent').style.height = '500px';
            obj('playerpagecontent').value = pagecontent;
            obj('playerpagecontent').onchange = () => {
                pagecontent = obj('playerpagecontent').value;
            }
        }
    }*/

    obj('playerpagecontent').onchange = () => {
        pagecontent = obj('playerpagecontent').value;
    }

    var btnreset = obj('btnreset');
    btnreset.onclick = () => {
        bgcolor.value='';
        obj('bgcolor').value='';
        textcolor.value='';
        obj('textcolor').value='';
        headercolor.value='';
        obj('headercolor').value='';
        menucolor.value='';
        obj('menucolor').value='';
        linkcolor.value='';
        obj('linkcolor').value='';
        linkhovercolor.value='';
        obj('linkhovercolor').value='';
        obj('twitchusername').value='';
    }

    var btnupdate = obj('btnupdate');
    btnupdate.onclick = () => {

        obj('file-upload-form').submit();

        var _font='font';
        var _bgcolor=obj('bgcolor').value;
        var _headercolor=obj('headercolor').value;
        var _textcolor=obj('textcolor').value;
        var _menucolor=obj('menucolor').value;
        var _linkcolor=obj('linkcolor').value;
        var _linkhovercolor=obj('linkhovercolor').value;
        var _pagecontent=pagecontent;

        $.ajax({
            type:'post',
            url:adminurl,
            data: {action:'updateplayerpage', 'UPDATINGIMAGE':'NO', 'font':_font, 'bgcolor':_bgcolor, 'headercolor':_headercolor, 'textcolor':_textcolor,'menucolor':_menucolor,'pagecontent':_pagecontent,
            'linkcolor':_linkcolor,'linkhovercolor':_linkhovercolor, 'twitchusername':obj('twitchusername').value},
            dataType: 'text',
            success:function(response) {
                alertify.set({ delay: 5000 }); 
                alertify.success("Profile updated successfully."); 
            },
            error:function(xhr, response, error) {
                console.error(response+': ' + error);
            }
        });
    }


});