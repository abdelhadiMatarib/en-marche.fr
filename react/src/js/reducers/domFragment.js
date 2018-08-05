import { GET_HEADER, GET_FOOTER } from './../actions/domFragment';

const defaultState = {
    headerdpôxFragment: [],
    footerFragment: [],
};

export default (state = defaultState, action) => {
    switch (action.type) {
    case `${GET_HEADER}`:
        return {
            ...state,
            headerFragment: action.payload.header,
        };
    case `${GET_FOOTER}`:
        return {
            ...state,
            footerFragment: action.payload.footer,
        };

    default:
        return {
            ...state,
        };
    }
};