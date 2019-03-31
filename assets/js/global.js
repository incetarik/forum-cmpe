var Global;
(function (Global) {
    var _loadCompleted = false;
    extendOnLoad(function () {
        Global.header = document.querySelector('header');
        Global.footer = document.querySelector('footer');
        Global.sidebar = document.getElementById('sidebar');
        Global.menu = document.getElementById('menu');
        Global.logo = document.getElementById('logo');
        document.onscroll = sideBarScrollHandler;
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