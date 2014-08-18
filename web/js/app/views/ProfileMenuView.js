App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfileMenuView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-menu-template',
        events: {
            'click .edit-button': 'showEditView',
            'click .contact-button': 'showContactView',
            'click .follow-button': 'toggleFollowUser'
        },
        showEditView: function(e) {
            var form = $(e.currentTarget).data('form');
            e.preventDefault();
            $('#clzk-profile-menu-actions-region .list-group-item').removeClass('active');

            if (form == 'profile') {
                Backbone.history.navigate(UserModule.targetUserUsername, { trigger: true });
            } else {
                $(e.currentTarget).addClass('active');
                Backbone.history.navigate(UserModule.targetUserUsername + '/edit/' + form, { trigger: true });
            }
        },
        showContactView: function(e) {
            e.preventDefault();
            if (UserModule.visitorId === null || UserModule.visitorId == '') {
                window.location.replace(Routing.generate('fos_user_security_login'));
                return;
            }
            Backbone.history.navigate(UserModule.targetUserUsername + '/contact', { trigger: true });
        },
        toggleFollowUser: function(e) {
            e.preventDefault();
            NProgress.start();
            var that = this;
            if (UserModule.visitorId === null || UserModule.visitorId == '') {
                window.location.replace(Routing.generate('fos_user_security_login'));
                return;
            }

            $.ajax({
                url: (typeof that.isFollowing() === 'undefined' ? Routing.generate('users_follow_user', { profileId: UserModule.targetUserProfile.get('id') }) : Routing.generate('users_unfollow_user', { profileId: UserModule.targetUserProfile.get('id') })),
                type: (typeof that.isFollowing() === 'undefined' ? 'POST' : 'DELETE'),
                dataType: 'json',
                success: function(data) {
                    (that.isFollowing() ? UserModule.visitor.get('following').splice(UserModule.visitor.get('following').indexOf(that.isFollowing()), 1) : UserModule.visitor.get('following').push(data));
                    that.render();
                    NProgress.done();
                },
                error: function(data) {
                    NProgress.done();
                    // console.log(data);
                }
            });
        },
        isFollowing: function() {
            return _.findWhere(UserModule.visitor.get('following'), { username: UserModule.targetUserUsername });
        },
        serializeData: function() {
            return {
                owner: (UserModule.userId === UserModule.visitorId ? true : false),
                isFollowing: (typeof this.isFollowing() === 'undefined' ? false : true)
                // full_name: this.model.get('firstname').toUpperCase() + ' ' + this.model.get('lastname').toUpperCase()
            }
        }
    });
});