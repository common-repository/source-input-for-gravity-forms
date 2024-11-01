(function () {
    // https://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    function checkForSource(sources) {
        var str = window.location.href;

        for (var i = 0; i < sources.length; i++) {
            var source = sources[i];
            
            if (source.pattern.type === 'getQuery') {
                
                if (getParameterByName(source.pattern.key)) {
                    
                    if (!source.pattern.value || getParameterByName(source.pattern.key) === source.pattern.value) {
                        sessionStorage.setItem('source_value', source.name + ': ' + source.pattern.key + '=' + getParameterByName(source.pattern.key));
                    }
                }
            }
        }
    }

    function updateSourceInput() {
        var input = document.getElementsByClassName('gfsi_source');

        if (input.length > 0 && sessionStorage.getItem('source_value')) {
            input[0].value = sessionStorage.getItem('source_value');
        }
    }

    checkForSource(gfsiSources);
    updateSourceInput();
})();