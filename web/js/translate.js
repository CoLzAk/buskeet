(function( $ ) {
    
    translate = function(msg, options) {
        var opts = $.extend( {}, translate.defaults, options );
        result = translate.getTranslation(msg, opts);
        return result;
    };

    translate.defaults = {
        lang : 'fr'
    };

    translate.getTranslation = function(msg, opts) {
        if (typeof opts !== 'undefined') {
            if (opts.format == 'short') {
                return translate.frWordsShorten[msg] || msg;
            }
        }
        return translate.frWords[msg] || msg;
    };

    translate.frWordsShorten = {
    };

    translate.frWords = {
    	BEGINNER: 'Débutant',
    	AMATEUR: 'Intermédiaire',
    	PROFESSIONAL: 'Expert',
        guitar: 'Guitare',
        bass: 'Basse',
        drums: 'Batterie',
        cajon: 'Cajon',
        piano: 'Piano',
        keyboard: 'Clavier',
        trumpet: 'Trompette',
        triangle: 'Triangle',
        conga: 'Conga',
        djembe: 'Djembé',
        ukulele: 'Ukulele',
        bagpipe: 'Cornemuse',
        flute: 'Flûte',
        clarinet: 'Clarinette',
        singing: 'Chant',
        beatboxing: 'Beatbox',
        mixing: 'Mixage',
        saxophone: 'Saxophone',
        violin: 'Violon',
        theremin: 'Thérémine',
        drummachine: 'Boite à rythme',
        ADDED_PHOTO: 'à ajouté une photo',
        ADDED_VIDEO: 'à ajouté une vidéo',
        CHANGED_PROFILE_PHOTO: 'à changé sa photo de profil',
        ADDED_EVENT: 'à ajouté un jam session',
        PARTICIPATE_EVENT: 'participe à un jam session',
        FOLLOWED_USER: 'suit désormais'

    };

})( jQuery );