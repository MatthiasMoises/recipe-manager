import axios from 'axios'

export const axiosClient = axios.create({
  baseURL: 'http://localhost:8000',
  withCredentials: false,
  headers: {
    'Content-Type': 'application/json',
    'App-Token': 'xCKc90BKy2K2xRJc'
  }
})
