App.module("UserModule", function(UserModule, FamileasyApp, Backbone, Marionette, $, _){

    File = Backbone.Model.extend({
        urlRoot: function(){
            return 'http://colzakfr.dev/app_dev.php/api/users/' + this.userId + '/files';
        },

        initialize: function(model, options) {
            if (typeof(this.collection) !== 'undefined')
                this.userId = options.userId;
            else
                this.userId = options.userId;
        }
    });

    Files = Backbone.Collection.extend({
        model: File,

        initialize: function(models, options) {
            this.userId = options.userId;
        },

        url: function(){
            // return Routing.generate('file_get_user_files', { username: this.username, fileType: this.fileType });
            return 'http://colzakfr.dev/app_dev.php/api/users/' + this.userId + '/files';
        }
    });
});
