fos.Router.setData({"base_url":"\/app_dev.php","routes":{"messages_get_thread_messages":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/messages"],["variable","\/","[^\/]++","threadId"],["text","\/api\/thread"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"messages_get_threads":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/threads"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"messages_post_messages":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","recipientId"],["text","\/api\/messages"]],"defaults":{"_format":"json"},"requirements":{"_method":"POST","_format":"json|xml|html"},"hosttokens":[]},"messages_post_thread_message":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/messages"],["variable","\/","[^\/]++","threadId"],["text","\/api\/thread"]],"defaults":{"_format":"json"},"requirements":{"_method":"POST","_format":"json|xml|html"},"hosttokens":[]},"colzak_user_inbox":{"tokens":[["text","\/messages"]],"defaults":[],"requirements":[],"hosttokens":[]},"events_toggle_participate":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/toggle"],["variable","\/","[^\/]++","eventId"],["text","\/api\/participates"]],"defaults":{"_format":"json"},"requirements":{"_method":"PATCH","_format":"json|xml|html"},"hosttokens":[]},"events_view":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/view"],["variable","\/","[^\/]++","eventId"],["text","\/api"]],"defaults":{"_format":"json"},"requirements":{"_method":"PATCH","_format":"json|xml|html"},"hosttokens":[]},"events_delete_user_events":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","id"],["text","\/events"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"DELETE","_format":"json|xml|html"},"hosttokens":[]},"events_get_events":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/api\/events"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"events_get_user_events":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/events"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"events_post_events_user_participate":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","userId"],["text","\/participate"],["variable","\/","[^\/]++","id"],["text","\/api\/events"]],"defaults":{"_format":"json"},"requirements":{"_method":"POST","_format":"json|xml|html"},"hosttokens":[]},"events_post_user_events":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/events"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"POST","_format":"json|xml|html"},"hosttokens":[]},"events_put_events":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","id"],["text","\/api\/events"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"events_put_user_events":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","id"],["text","\/events"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"colzak_event_participate":{"tokens":[["variable","\/","[^\/]++","eventId"],["text","\/event\/participate"]],"defaults":[],"requirements":[],"hosttokens":[]},"colzak_event":{"tokens":[["variable","\/","[^\/]++","eventId"],["text","\/event"]],"defaults":[],"requirements":[],"hosttokens":[]},"photos_delete_user_photos":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","photoId"],["text","\/photos"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"DELETE","_format":"json|xml|html"},"hosttokens":[]},"photos_get_user_photos":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/photos"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"photos_post_user_photos":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/photos"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"POST","_format":"json|xml|html"},"hosttokens":[]},"photos_put_user_photos":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","photoId"],["text","\/photos"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"colzak_search_result":{"tokens":[["variable","\/","[^\/]++","direction"],["variable","\/","[^\/]++","localization"],["text","\/s"]],"defaults":{"localization":"FR","direction":""},"requirements":{"_method":"GET"},"hosttokens":[]},"colzak_search_result_preview":{"tokens":[["variable","\/","[^\/]++","itemId"],["text","\/preview"],["variable","\/","[^\/]++","direction"],["variable","\/","[^\/]++","localization"],["text","\/s"]],"defaults":{"localization":"FR"},"requirements":{"_method":"GET"},"hosttokens":[]},"search_index":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/index"],["variable","\/","[^\/]++","localization"],["text","\/api"]],"defaults":{"_format":"json"},"requirements":{"_method":"PATCH","_format":"json|xml|html"},"hosttokens":[]},"search_redirect":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/redirect"],["variable","\/","[^\/]++","localization"],["text","\/api"]],"defaults":{"_format":"json"},"requirements":{"_method":"PATCH","_format":"json|xml|html"},"hosttokens":[]},"search_get_search":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","direction"],["variable","\/","[^\/]++","localization"],["text","\/api\/search"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"portfolios_get_user_portfolio":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/portfolio"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"portfolios_put_user_portfolio":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","portfolioId"],["text","\/portfolio"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"instruments_get_all_instruments":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/api\/instruments"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"instruments_get_instruments":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","slug"],["text","\/api\/instruments"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"geo_get_public_places":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/api\/geo\/public\/places"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"colzak_add_public_place":{"tokens":[["text","\/public\/places\/add"]],"defaults":[],"requirements":[],"hosttokens":[]},"colzak_public_places":{"tokens":[["variable","\/","[^\/]++","locality"],["text","\/public\/places"]],"defaults":[],"requirements":[],"hosttokens":[]},"colzak_user_feed":{"tokens":[["text","\/home"]],"defaults":[],"requirements":[],"hosttokens":[]},"colzak_user_homepage":{"tokens":[["variable","\/","[^\/]++","slug2"],["variable","\/","[^\/]++","slug1"],["variable","\/","[^\/]++","username"],["text","\/profile"]],"defaults":{"username":"me","slug1":"","slug2":""},"requirements":[],"hosttokens":[]},"users_follow_user":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","profileId"],["text","\/api\/follow\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"POST","_format":"json|xml|html"},"hosttokens":[]},"users_unfollow_user":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","profileId"],["text","\/api\/unfollow\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"DELETE","_format":"json|xml|html"},"hosttokens":[]},"users_get_feeds":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/api\/feeds"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"users_get_feeds_events":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/api\/feeds\/events"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"users_get_feeds_profiles":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/api\/feeds\/profiles"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"users_get_profiles":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/api\/users\/profiles"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"users_get_user":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","identifier"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"users_get_user_profile":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/profile"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"users_get_users":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"users_put_user":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","id"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"users_put_user_profile":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","id"],["text","\/profile"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"fos_user_security_login":{"tokens":[["text","\/login"]],"defaults":[],"requirements":[],"hosttokens":[]},"fos_user_security_check":{"tokens":[["text","\/login_check"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"fos_user_security_logout":{"tokens":[["text","\/logout"]],"defaults":[],"requirements":[],"hosttokens":[]}},"prefix":"","host":"localhost","scheme":"http"});