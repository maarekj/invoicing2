(function() {
    angular.module('preventDefault', []).directive('preventDefault', function() {
        return function(scope, element, attrs) {
            element.bind('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
            });
        }
    });
})();