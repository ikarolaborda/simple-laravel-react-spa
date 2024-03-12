import axios from "axios";

const baseURL = '/api/v1/posts';

const fetchPosts = (page, searchCriteria = '') => {
    return axios.get(baseURL, {params:  { page, search: searchCriteria }}).then(response => response.data);
};

export const PostService = {
    fetchPosts,
};
