App.module("SearchModule", function(SearchModule, App, Backbone, Marionette, $, _){

    SearchMenuView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-search-menu-template',
        bindings: {
            '#filter-radius-value': {
                observe: 'params.radius',
                onGet: function(value) {
                    return Math.round(value) || 20;
                },
                onSet: function(value) {
                    return Math.round(value);
                }
            },
            '#filter-gender': 'params.gender',
            '#filter-age': 'params.age',
            '#filter-category': 'params.category',
            '#filter-experience': 'params.experience'
        },
        events: {
            'change .search-filter': 'updateResults'
        },
        updateResults: function(e) {
            var value = $(e.currentTarget).val();
            e.preventDefault();
            if ($(e.currentTarget).attr('type') == 'checkbox') {
                value = $(e.currentTarget).is(':checked');
            }
            if (value !== '' && value.length !== 0 && value !== false) {
                this.model.queryUrl.searchParams[$(e.currentTarget).attr('data-filter')] = value;

            } else {
                delete this.model.queryUrl.searchParams[$(e.currentTarget).attr('data-filter')];
            }

            Backbone.history.navigate(this.objectToUrl(this.model.queryUrl), { trigger: true });
        },
        objectToUrl: function(queryUrl) {
            var url = queryUrl.localization;
            var i = 0;
            for (var param in queryUrl.searchParams) {
                if (param != 'lat' && param != 'lng' && param != 'page') {
                    if (i === 0) url += '?';
                    url += param + '=' + queryUrl.searchParams[param] + '&';
                    i++;
                }
            }
            if (url.slice(-1) == '&') url = url.substring(0, url.length - 1);
            return url;
        },
        onDomRefresh: function() {
            var categories = (typeof this.model.get('params').category !== 'undefined' ? this.model.get('params').category.split(',') : []);

            this.initMap();
            $('#filter-radius').noUiSlider({
                start: [ this.model.get('params').radius || 20 ],
                connect: 'lower',
                step: 1,
                range: {
                    'min': 1,
                    'max': 20
                },
                serialization: {
                    lower: [
                        $.Link({
                            target: $("#filter-radius-value")
                        })
                    ],
                    format: {
                        decimals: 0
                    }
                }
            });
            // $('#filter-radius').on('slide', function(e, val) {
            //     $('#filter-radius-value').html(val);
            // });

            for (var i in categories) {
                $('#' + categories[i] + '-category').prop('checked', true);
            }

            //Click on the instruments family
            $('.filter-category').click(function(e) {
                var filterCategories = $('#filter-category'),
                    category = '';
                if (e.currentTarget.checked === true) {
                    if (filterCategories.val().length > 0) category += ',';
                    category += $(e.currentTarget).data('category');
                    filterCategories.val(filterCategories.val() + category);
                } else {
                    filterCategories.val(filterCategories.val().replace($(e.currentTarget).data('category'), ''));
                    while (filterCategories.val().slice(-1) == ',') {
                        filterCategories.val(filterCategories.val().substring(0, filterCategories.val().length - 1));
                    }
                    while (filterCategories.val().charAt(0) == ',') {
                        filterCategories.val(filterCategories.val().substring(1));
                    }
                }
                filterCategories.trigger('change');
            });
        },
        initMap: function() {
            var profiles = this.model.get('items');
            var markers = '';
            var mapWidth = $('#map').width();
            var mapUrl = '';

            for (var i in profiles.models) {
                if (typeof profiles.models[i].coordinates.y !== 'undefined' || profiles.models[i].coordinates.y !== null && typeof profiles.models[i].coordinates.x !== 'undefined' || profiles.models[i].coordinates.x !== null) {
                    markers += '&markers=color:red|' + profiles.models[i].coordinates.y + ',' + profiles.models[i].coordinates.x;
                }
            }
            mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center='+ this.model.queryUrl.searchParams['lat'] +','+ this.model.queryUrl.searchParams['lng'] +'&zoom=12&size='+mapWidth+'x180&maptype=roadmap&sensor=false' + markers;
            $('#map').html('<img src="'+ mapUrl +'">');
        },
        initialize: function(model) {
            // this.queryUrl = model.queryUrl;
            // console.log(this.model);

            // this.currentSearchCoordinates = {
            //     lat: SearchModule.queryUrl.filters['lat'],
            //     lng: SearchModule.queryUrl.filters['lng']
            // };
        },
        onRender: function() {
            this.stickit();
        }
    });

    SearchResultView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-search-result-template',
        tagName: 'div',
        serializeData: function() {
            var profile_picture = _.findWhere(this.model.get('photos'), { is_profile_picture: true });

            return {
                profile_picture_path: profile_picture.thumb_path,
                profile: this.model.toJSON()
            };
        },
        onDomRefresh: function() {
            var that = this;
            $('.clzk-search-profile-container').on('click', function(e) {
                e.preventDefault();
                window.location.href = Routing.generate('colzak_user_homepage', { username: that.model.get('username') });
            });
        }
    });

    SearchResultEmptyView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-search-result-empty-template'
    });

    SearchResultsView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-search-results-template',
        itemView: SearchResultView,
        emptyView: SearchResultEmptyView,
        itemViewContainer: '#clzk-search-result-container',
        serializeData: function() {
            return {
                results: this.collection.toJSON()
            };
        }
    });
});