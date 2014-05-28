fos.Router.setData({"base_url":"\/app_dev.php","routes":{"events_get_user_events":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/events"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"events_post_user_events":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/events"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"POST","_format":"json|xml|html"},"hosttokens":[]},"events_put_user_events":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","id"],["text","\/events"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"photos_get_user_photos":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/photos"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"photos_post_user_photos":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/photos"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"POST","_format":"json|xml|html"},"hosttokens":[]},"colzak_search_result":{"tokens":[["variable","\/","[^\/]++","category"],["variable","\/","[^\/]++","localization"],["text","\/s"]],"defaults":{"localization":"FR","category":"all"},"requirements":{"_method":"GET"},"hosttokens":[]},"search_get_search":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","category"],["variable","\/","[^\/]++","localization"],["text","\/api\/search"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"portfolios_get_user_portfolio":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/portfolio"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"portfolios_put_user_portfolio":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","portfolioId"],["text","\/portfolio"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"instruments_get_all_instruments":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/api\/instruments"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"instruments_get_instruments":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","slug"],["text","\/api\/instruments"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"users_get_user":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","identifier"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"users_get_user_profile":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/profile"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"users_get_users":{"tokens":[["variable",".","json|xml|html","_format"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"GET","_format":"json|xml|html"},"hosttokens":[]},"users_put_user":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","id"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]},"users_put_user_profile":{"tokens":[["variable",".","json|xml|html","_format"],["variable","\/","[^\/\\.]++","id"],["text","\/profile"],["variable","\/","[^\/]++","userId"],["text","\/api\/users"]],"defaults":{"_format":"json"},"requirements":{"_method":"PUT","_format":"json|xml|html"},"hosttokens":[]}},"prefix":"","host":"localhost","scheme":"http"});