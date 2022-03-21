import { BrowserRouter as Router, Switch, Route } from 'react-router-dom';

import { Home } from '../../pages/home/home';

export const App = () => {
    return (
        <Router>
            <Switch>
                <Route exact path="/">
                    <Home />
                </Route>
            </Switch>
        </Router>
    );
}
