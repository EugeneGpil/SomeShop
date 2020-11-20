export const userlist = {
    state: {
        userlist: {
            users: [],
            currentPage: 1,
            nextPage: null,
            prevPage: null,
            perPage: 20,
            pageToGo: null,
            search: null
        }
    },
    mutations: {
        setUserlistUsers(state, users) {
            state.userlist.users = users;
        },
        setUserlistPrevPage(state, page) {
            state.userlist.prevPage = page;
        },
        setUserlistNextPage(state, page) {
            state.userlist.nextPage = page;
        },
        setUserlistPageToGo(state, page) {
            state.userlist.pageToGo = page;
        }
    },
    actions: {
        setUserlistPageToGo(context, page) {
            context.commit('setUserlistPageToGo', page);
        },
        setUserlist({commit, getters}, resp) {

            let users = resp.entities;

            for (let i = 0; i < users.length; i++) {
                users[i].route = {name: 'user', params: {id: users[i].id}};
                users[i].created_at = undefined;
                users[i].updated_at = undefined;
            }
            commit('setUserlistUsers', users);

            if (resp.is_prev_page_exist) {
                commit('setUserlistPrevPage', parseInt(getters.userlist.currentPage) - 1);
            } else {
                commit('setUserlistPrevPage', null);
            }
            if (resp.is_next_page_exist) {
                commit('setUserlistNextPage', parseInt(getters.userlist.currentPage) + 1);
            } else{
                commit('setUserlistNextPage', null);
            }
        }
    },
    getters: {
        userlist(state) {
            return state.userlist;
        }
    }
}