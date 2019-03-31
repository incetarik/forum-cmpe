var Global;
(function (Global) {
    var _loadCompleted = false;
    function slice(items) {
        return Array.prototype.slice.call(items);
    }
    Global.slice = slice;
    extendOnLoad(function () {
        Global.header = document.querySelector('header');
        Global.footer = document.querySelector('footer');
        Global.sidebar = document.getElementById('sidebar');
        Global.menu = document.getElementById('menu');
        Global.logo = document.getElementById('logo');
        if (Global.sidebar) {
            document.onscroll = sideBarScrollHandler;
        }
    });
    // ───────────────────────────[ Helpers ]────────────────────────────────────
    function extendOnLoad(handler) {
        if (_loadCompleted) {
            handler.call(window);
            return;
        }
        var previous = window.onload;
        window.onload = function () {
            _loadCompleted = true;
            if (typeof previous === 'function')
                previous.call(window);
            handler.call(window);
        };
        return window;
    }
    Global.extendOnLoad = extendOnLoad;
    function get(url, callback) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                callback(xmlhttp.responseText);
            }
        };
        xmlhttp.responseType = 'json';
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
    Global.get = get;
    function post(url, data, callback) {
        var formData = new FormData();
        if (data) {
            for (var key in data) {
                var value = data[key];
                formData.append(key, value.toString());
            }
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                callback(xmlhttp.response);
            }
        };
        xmlhttp.responseType = 'json';
        xmlhttp.open("POST", url, true);
        xmlhttp.send(formData);
    }
    Global.post = post;
    function sideBarScrollHandler() {
        var style = Global.sidebar.style;
        var menuClassList = Global.menu.classList;
        var logoClassList = Global.logo.classList;
        if (scrollY >= 64) {
            menuClassList.add('fixed');
            logoClassList.add('fixed');
        }
        else {
            menuClassList.remove('fixed');
            logoClassList.remove('fixed');
        }
        if (scrollY <= 70) {
            style.marginTop = (-scrollY).toString().concat('px');
        }
        else {
            style.marginTop = '-68px';
        }
    }
})(Global || (Global = {}));
//# sourceMappingURL=global.js.map